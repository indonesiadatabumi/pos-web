@extends('layouts.default')

@section('title', 'Managed Tables')

@push('css')
<link href="/assets/plugins/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
<link href="/assets/plugins/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" />

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<style>
    body {
        font-family: 'Poppins', sans-serif;
    }

    h1 {
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
    }

    .panel-heading .title {
        font-family: 'Poppins', sans-serif;
        font-weight: 400;
    }

    table {
        font-family: 'Poppins', sans-serif;
        font-size: 11px;
    }
</style>

@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="/assets/plugins/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="/assets/plugins/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script src="/assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="/assets/plugins/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
<script src="/assets/js/demo/table-manage-default.demo.js"></script>
<script src="/assets/plugins/@highlightjs/cdn-assets/highlight.min.js"></script>
<script src="/assets/js/demo/render.highlight.js"></script>
@endpush

@section('content')
<!-- BEGIN breadcrumb -->
<ol class="breadcrumb float-xl-end">
    <li class="breadcrumb-item"><a href="javascript:;">Pelayanan</a></li>
    <li class="breadcrumb-item"><a href="javascript:;">Daftar Wajib Pajak</a></li>
</ol>
<!-- END breadcrumb -->

<!-- BEGIN page-header -->
<h1>Daftar Wajib Pajak</h1>
<!-- END page-header -->

<!-- BEGIN panel -->
<div class="panel panel-default">
    <!-- BEGIN panel-heading -->
    <div class="panel-heading">
        <i class="fas fa-sign-in-alt icon"></i>
        <div class="title">Daftar Usaha saya</div>
    </div>
    <!-- END panel-heading -->

    <!-- BEGIN panel-body -->
    <div class="panel-body">
        <table id="data-table-default" class="table table-striped table-bordered align-middle">
            <thead>
                <tr>
                    <th width="1%">No.</th>
                    <th class="text-nowrap">NPWRD</th>
                    <th class="text-nowrap">NAMA WR</th>
                    <th class="text-nowrap">NAMA</th>
                    <!-- <th class="text-nowrap">KOTA</th> -->
                    <th class="text-nowrap">KELURAHAN/KECAMATAN</th>
                    <!-- <th class="text-nowrap">TEMPAT/TGL LAHIR</th>
                        <th class="text-nowrap">ALAMAT</th>
                        <th class="text-nowrap">NO HANDPHONE</th>
                        <th class="text-nowrap">NO REKENING</th> -->
                    <th class="text-nowrap">ALAMAT USAHA</th>
                    <!-- <th class="text-nowrap">EMAIL</th> -->
                    <th class="text-nowrap">PEMILIK</th>
                    <th class="text-nowrap">TANGGAL TERDAFTAR</th>
                    <th class="text-nowrap">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($daftarUsaha as $index => $usaha)
                <tr>
                    <td class="fw-bold text-dark">{{ $index + 1 }}.</td>
                    <td>
                        @php
                        $npwrd = $usaha->npwrd;
                        $formattedNpwr = substr($npwrd, 0, 1) . '.' . substr($npwrd, 1);
                        @endphp
                        {{ $formattedNpwr }}
                    </td>

                    <td>{{ $usaha->nm_wr }}</td>
                    <td>{{ $usaha->nama }}</td>
                    <!-- <td>{{ $usaha->kota }}</td>  -->
                    <td>{{ $usaha->kelurahan->nm_kelurahan }} / {{ $usaha->kecamatan->nm_kecamatan }}</td>
                    <!-- <td>{{ $usaha->tempat_lahir }} / {{ \Carbon\Carbon::parse($usaha->tanggal_lahir)->format('d-m-Y') }}</td> 
                        <td>{{ $usaha->alamat }}</td> 
                        <td>{{ $usaha->no_handphone }}</td> 
                        <td>{{ $usaha->no_rekening }}</td>  -->
                    <td>{{ $usaha->alamat_usaha }}</td>
                    <!-- <td>{{ $usaha->email}}</td> -->
                    <td>{{ $usaha->pemilik }}</td>
                    <td>{{ $usaha->created_at->setTimezone('Asia/Jakarta')->format('d-m-Y H:i:s') }}</td>

                    <td class="text-center">

                        <a href="{{ route('pages.daftar.usaha.lihat', $usaha->id) }}" class="btn btn-info btn-sm me-1">
                            <i class="fa fa-eye"></i>
                        </a>
                        <button class="btn btn-success btn-sm me-1" onclick="openEditModal({{ $usaha }})">
                            <i class="fas fa-edit"></i>
                        </button>

                        <a href="{{ route('pages.daftar.usaha.cetak', $usaha->id) }}" class="btn btn-warning btn-sm me-1" target="_blank">
                            <i class="fa fa-print"></i>
                        </a>


                        <form action="{{ route('daftar.usaha.destroy', $usaha->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!-- END panel-body -->

<!-- BEGIN Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Daftar Usaha</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="no_registrasi" class="form-label">NO. REGISTRASI</label>
                        <input type="text" class="form-control-2" id="no_registrasi" name="no_registrasi" required readonly>
                    </div>
                    <div class="mb-3">
                        <label for="nm_wr" class="form-label">NAMA WR</label>
                        <input type="text" class="form-control" id="nm_wr" name="nm_wr" required>
                    </div>
                    <div class="mb-3">
                        <label for="npwrd" class="form-label">NPWRD</label>
                        <input type="text" class="form-control-2" id="npwrd" name="npwrd" required readonly>
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="kota" class="form-label">Kota</label>
                        <input type="text" class="form-control" id="kota" name="kota" required>
                    </div>
                    <!-- <div class="mb-3">
                            <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                            <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
                        </div> -->
                    <div class="mb-3">
                        <label for="id_kecamatan" class="form-label">Kecamatan</label>
                        <select class="form-control" id="id_kecamatan" name="id_kecamatan" required>
                            <option value="">Pilih Kecamatan</option>
                            <!-- Options will be loaded via AJAX -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="id_kelurahan" class="form-label">Kelurahan</label>
                        <select class="form-control" id="id_kelurahan" name="id_kelurahan" required>
                            <option value="">Pilih Kelurahan</option>
                            <!-- Options will be loaded via AJAX based on selected Kecamatan -->
                        </select>
                    </div>

                    <!-- <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" required>
                        </div> -->
                    <div class="mb-3">
                        <label for="no_handphone" class="form-label">No Handphone</label>
                        <input type="text" class="form-control" id="no_handphone" name="no_handphone" required>
                    </div>
                    <!-- <div class="mb-3">
                            <label for="no_rekening" class="form-label">No Rekening</label>
                            <input type="text" class="form-control" id="no_rekening" name="no_rekening" required>
                        </div> -->
                    <div class="mb-3">
                        <label for="alamat_usaha" class="form-label">Alamat Usaha</label>
                        <input type="text" class="form-control" id="alamat_usaha" name="alamat_usaha" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="pemilik" class="form-label">Pemilik</label>
                        <input type="text" class="form-control" id="pemilik" name="pemilik">
                    </div>
                    <div class="mb-3">
                        <label for="foto" class="form-label">Upload Identitas</label>
                        <input type="file" class="form-control" id="foto" name="foto" />
                        <small class="form-text text-muted">Maksimal ukuran 2MB, format gambar(png,jpg,jpeg).</small>
                        <div>
                            <img id="fotoImage" src="" alt="Foto KTP" class="img-thumbnail" style="max-height: 200px;">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
            </form>
        </div>
    </div>
</div>
<!-- END Edit Modal -->

<script>
    $(document).ready(function() {
        $('#data-table-default').DataTable({});
    });

    function openEditModal(usaha) {
        $('#no_registrasi').val(usaha.no_registrasi);
        $('#nm_wr').val(usaha.nm_wr);
        $('#npwrd').val(usaha.npwrd);
        $('#nama').val(usaha.nama);
        $('#kota').val(usaha.kota);
        $('#no_handphone').val(usaha.no_handphone);
        $('#email').val(usaha.email);
        $('#alamat_usaha').val(usaha.alamat_usaha);
        $('#pemilik').val(usaha.pemilik);
        $('#fotoImage').attr('src', '/storage/foto/' + usaha.foto);


        $('#editForm').attr('action', '/daftar/usaha/update/' + usaha.id);

        $('#editForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: new FormData(this),
                contentType: false,
                processData: false,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Data berhasil diperbarui',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Terjadi kesalahan, coba lagi',
                    });
                }
            });
        });

        $.ajax({
            url: '/kecamatan',
            method: 'GET',
            success: function(data) {
                $('#id_kecamatan').empty().append('<option value="">Pilih Kecamatan</option>');
                data.forEach(function(kecamatan) {
                    $('#id_kecamatan').append(new Option(kecamatan.nm_kecamatan, kecamatan.kd_kecamatan));
                });
                $('#id_kecamatan').val(usaha.kd_kecamatan);


                loadKelurahanOptions(usaha.kd_kecamatan, usaha.kd_kelurahan);
            }
        });


        $('#id_kecamatan').on('change', function() {
            const kecamatanId = $(this).val();
            loadKelurahanOptions(kecamatanId, null);
        });


        $('#editModal').modal('show');
    }


    function loadKelurahanOptions(kecamatanId, selectedKelurahanId) {
        if (!kecamatanId) {
            $('#id_kelurahan').empty().append('<option value="">Pilih Kelurahan</option>');
            return;
        }

        $.ajax({
            url: '/get-kelurahan/' + kecamatanId,
            method: 'GET',
            success: function(data) {
                $('#id_kelurahan').empty().append('<option value="">Pilih Kelurahan</option>');
                data.forEach(function(kelurahan) {
                    $('#id_kelurahan').append(new Option(kelurahan.nm_kelurahan, kelurahan.kd_kelurahan));
                });

                if (selectedKelurahanId) {
                    $('#id_kelurahan').val(selectedKelurahanId);
                }
            }
        });
    }
</script>
@endsection