@extends('layouts.default')

@section('title', 'Permohonan Nomor Faktur')

@push('css')
<link href="/assets/plugins/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
<link href="/assets/plugins/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
<script src="/assets/plugins/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="/assets/plugins/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script src="/assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="/assets/plugins/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
<script src="/assets/js/demo/table-manage-responsive.demo.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectElement = document.getElementById('retribusi');
            
            const selectedValue = selectElement.value;
            console.log("Nilai yang dipilih: " + selectedValue);

            selectElement.addEventListener('change', function() {
                const selectedValue = selectElement.value;
                console.log("Nilai yang dipilih: " + selectedValue);
            });
        });
    </script> -->
@endpush

@section('content')
<!-- BEGIN Breadcrumb -->
<ol class="breadcrumb float-xl-end">
    <li class="breadcrumb-item"><a href="javascript:;">Permohonan</a></li>
    <li class="breadcrumb-item"><a href="javascript:;">Permohonan Nomor Faktur</a></li>
</ol>

<!-- BEGIN Header -->
<h1>PERMOHONAN NOMOR FAKTUR</h1>

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fas fa-sign-in-alt icon"></i>
                    <div class="title">Input Data Permohonan Nomor Faktur</div>
                </div>
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>


                @endif

                <div class="container-fluid mt-3">
                    <form id="permohonanForm" action="{{ route('verifikasi.permohonan.store') }}" method="POST">
                        @csrf
                        <div class="form-group row align-items-center">
                            <div class="row">
                                <div class="col-12">
                                    <h4>
                                        <b>No. Permohonan :{{ $nomorPermohonan }} <span name="no_permohonan" id="no_permohonan_input" value="{{ $nomorPermohonan }}"></span></b>
                                    </h4>
                                </div>
                            </div>
                            <label for="npwrd" class="col-sm-3 col-form-label fw-bold">Pilih Nama</label>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <select name="npwrd" id="npwrd" class="form-control custom-select shadow-sm" required>
                                        @php

                                        $userRoleId = auth()->user()->role_id;

                                        if ($userRoleId === 3) {
                                        $filteredDaftarUsaha = $daftarUsaha->filter(function($usaha) {
                                        return $usaha->nama === auth()->user()->fullname;
                                        });
                                        } else {
                                        $filteredDaftarUsaha = $daftarUsaha;
                                        }
                                        @endphp

                                        <option value="" selected disabled>-- Pilih Nama --</option>
                                        @foreach ($filteredDaftarUsaha as $usaha)
                                        <option value="{{ $usaha->npwrd }}">{{ $usaha->nama }}</option>
                                        @endforeach

                                               
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row align-items-center mt-3">
                            <label for="kd_rekening" class="col-sm-3 col-form-label fw-bold">Pilih Retribusi</label>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-receipt"></i>
                                    </span>
                                    <select name="kd_rekening" id="kd_rekening" class="form-control custom-select shadow-sm" required>
                                        <option value="" selected disabled>-- Pilih Retribusi --</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="card p-3" style="background: #DEE1E6;">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h4>Informasi Wajib Pajak</h4>
                                        <b><strong>Tanggal: </strong><span id="currentDate"></span></b>
                                    </div>
                                    <br>
                                    <h2>
                                        <b><span id="nm_wr" name="nm_wr"></span></b>
                                    </h2>
                                    <br>
                                    <br>
                                    <h5>
                                        <b>NPWRD : <span id="npwrd_display" name="npwrd"></span></b>
                                    </h5>
                                    <br>
                                    <h5>
                                        <p><strong><i class="fas fa-building me-2"></i> Alamat Usaha :</strong> <span
                                                id="alamat_usaha" name="alamat_usaha"></span></p>
                                    </h5>
                                    <h5>
                                        <p><strong><i class="fas fa-phone me-2"></i> No. Handphone :</strong> <span
                                                id="no_handphone" name="no_handphone"></span></p>
                                    </h5>


                                    <h5>
                                        <p><strong><i class="fas fa-user me-2"></i> Pemilik :</strong> <span
                                                id="pemilik" name="pemilik"></span></p>
                                    </h5>
                                </div>
                            </div>


                            <input type="hidden" id="no_permohonan" name="no_permohonan" value="{{ $nomorPermohonan }}">
                            <input type="hidden" id="nama" name="nama" value="">
                            <input type="hidden" id="nm_wr" name="nm_wr" value="">
                            <!-- <input type="hidden" id="nik" name="nik" value=""> -->
                            <input type="hidden" id="alamat_usaha" name="alamat_usaha" value="">
                            <input type="hidden" id="no_handphone" name="no_handphone" value="">
                            <input type="hidden" id="pemilik" name="pemilik" value="">
                            <div class="panel-body mt-4">
                                <table id="data-table-responsive" class="table table-striped table-bordered align-middle">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>NO SERI</th>
                                            <th>NO AWAL</th>
                                            <th>NO AKHIR</th>
                                            <th>JUMLAH LEMBAR</th>
                                            <th>TARIF</th>
                                            <th>TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1.</td>
                                            <td><input type="text" id="no_seri_1" name="no_seri[]" class="form-control" placeholder="Masukkan No Seri" required></td>
                                            <td><input type="number" id="no_awal_1" name="no_awal[]" class="form-control" placeholder="Masukkan No Awal" required></td>
                                            <td><input type="number" id="no_akhir_1" name="no_akhir[]" class="form-control" placeholder="Masukkan No Akhir" required></td>
                                            <td><input type="number" id="jml_lembar_1" name="jml_lembar[]" class="form-control-jml_lembar" placeholder="Jumlah Lembar" required readonly></td>
                                            <td><input type="number" id="tarif_1" name="tarif[]" class="form-control" placeholder="Tarif" required></td>
                                            <td><input type="number" id="total_1" name="total[]" class="form-control-jml_lembar" placeholder="Total" required readonly></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <button type="button" id="addRow" class="btn btn-success mt-3">Tambah Row</button>
                            </div>

                            <div class="d-flex justify-content-end mt-3">
                                <button type="reset" class="btn btn-danger me-2">Reset</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="module">
    $(document).ready(function() {
        $('#npwrd').select2({
            placeholder: '-- Pilih Nama --',
            allowClear: true,
            width: 'resolve'
        });

        const date = new Date();
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const year = date.getFullYear();
        document.getElementById('currentDate').textContent = `${day}/${month}/${year}`;

        $('#npwrd').change(function() {
            const npwrd = $(this).val();


            if (npwrd) {
                $.ajax({
                    url: `{{ url('/permohonan/faktur/get-data') }}/${npwrd}`,
                    method: 'GET',
                    success: function(data) {
                        if (data) {
                            $('#no_permohonan').text(data.no_permohonan);
                            $('#nm_wr').text(data.nm_wr);
                            $('#nama').text(data.nama);
                            // $('#nik').text(data.nik);
                            const formattedNpwrd = formatNpwrd(data.npwrd);
                            $('#npwrd_display').text(formattedNpwrd);
                            $('#alamat_usaha').text(data.alamat_usaha);
                            $('#no_handphone').text(data.no_handphone);
                            $('#pemilik').text(data.pemilik);
                            // const pemilik = data.pemilik;
                            // $(input[name="pemilik"][value="${pemilik}"])
                            //     .prop('checked', true);
                            //    $('input[name="pemilik"]').prop('enabled', true);
                            $('input[name="no_permohonan"]').val('{{ $nomorPermohonan }}');
                            $('input[name="nama"]').val(data.nama);
                            $('input[name="nm_wr"]').val(data.nm_wr);
                            // $('input[name="nik"]').val(data.nik);
                            $('input[name="alamat_usaha"]').val(data.alamat_usaha);
                            $('input[name="no_handphone"]').val(data.no_handphone);
                            $('input[name="pemilik"]').val(data.pemilik);

                            // console.log(
                            //     Pemilik yang dipilih: ${pemilik});


                            // Sekarang kita ambil data retribusi berdasarkan daftar_id
                            $.ajax({
                                url: `{{ url('/permohonan/faktur/retribusi') }}/${data.daftar_id}`, // Kirim daftar_id
                                method: 'GET',
                                success: function(retribusiData) {
                                    if (retribusiData.length > 0) {
                                        // Membuat opsi dropdown berdasarkan data retribusi yang diterima
                                        const retribusiOptions = retribusiData.map(item =>
                                            `<option value="${item.kd_rekening}"> ${item.kd_rekening} - ${item.nm_retribusi}</option>`
                                        ).join('');

                                        // Menambahkan opsi default pertama jika diperlukan
                                        $('#kd_rekening').html(`<option value="" selected disabled>-- Pilih Retribusi --</option>  ${retribusiOptions} `);
                                    } else {
                                        $('#kd_rekening').html('<option value="" selected disabled>-- Tidak Ada Retribusi --</option>');
                                    }
                                },
                                error: function() {
                                    $('#kd_rekening').html('<option value="" selected disabled>-- Tidak Ada Retribusi --</option>');
                                }
                            });
                        } else {
                            console.error("Data usaha tidak ditemukan.");
                        }
                    },
                    error: function(jqXHR) {
                        console.error("Terjadi kesalahan dalam mengambil data usaha.", jqXHR);
                    }
                });


            } else {
                $('#no_permohonan').text('');
                $('#nm_wr').text('');
                $('#nama').text('');
                // $('#nik').text('');
                $('#npwrd_display').text('');
                $('#alamat_usaha').text('');
                $('#no_handphone').text('');
                $('#pemilik').text('');

                $('input[name="no_permohonan"]').val('');
                $('input[name="nm_wr"]').val('');
                $('input[name="nama"]').val('');
                // $('input[name="nik"]').val('');
                $('input[name="alamat_usaha"]').val('');
                $('input[name="no_handphone"]').val('');
                $('input[name="pemilik"]').val('');
            }
        });
    });

    $('#permohonanForm').submit(function(e) {
        e.preventDefault();

        // const retribusi = $('#kd_rekening').val();
        // if (!retribusi) {
        //     Swal.fire({
        //         icon: 'error',
        //         title: 'Oops...',
        //         text: 'Harap pilih Retribusi yang valid!',
        //     });
        //     return; // Mencegah form untuk disubmit
        // }

        if (this.checkValidity() === false) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Harap lengkapi semua data yang diperlukan!',
            });
        } else {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data akan disimpan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, simpan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        }
    });

    $('#addRow').click(function() {
        const rowCount = $('#data-table-responsive tbody tr').length + 1;
        const newRow = `
            <tr>
                <td>${rowCount}.</td>
                <td><input type="text" id="no_seri_${rowCount}" name="no_seri[]" class="form-control" placeholder="Masukkan No Seri" required></td>
                <td><input type="number" id="no_awal_${rowCount}" name="no_awal[]" class="form-control" placeholder="Masukkan No Awal" required></td>
                <td><input type="number" id="no_akhir_${rowCount}" name="no_akhir[]" class="form-control" placeholder="Masukkan No Akhir" required></td>
                <td><input type="number" id="jml_lembar_${rowCount}" name="jml_lembar[]" class="form-control-jml_lembar" placeholder="Jumlah Lembar" required readonly></td>
                <td><input type="number" id="tarif_${rowCount}" name="tarif[]" class="form-control" placeholder="Tarif" required></td>
                <td><input type="number" id="total_${rowCount}" name="total[]" class="form-control-jml_lembar" placeholder="Total" required readonly></td>

            </tr>
        `;


        $('#data-table-responsive tbody').append(newRow);
    });


    $(document).on('input', '[id^="no_awal_"], [id^="no_akhir_"]', function() {
        const row = $(this).closest('tr');
        const noAwal = parseInt(row.find('input[name^="no_awal"]').val()) || 0;
        const noAkhir = parseInt(row.find('input[name^="no_akhir"]').val()) || 0;
        const jumlahLembar = noAkhir >= noAwal ? (noAkhir - noAwal + 1) : 0;
        row.find('input[name^="jml_lembar"]').val(jumlahLembar);
    });

    $(document).on('input', '[id^="jml_lembar_"], [id^="tarif_"]', function() {
        const row = $(this).closest('tr');
        const jmlLembar = parseInt(row.find('input[name^="jml_lembar"]').val()) || 0;
        const tarif = parseInt(row.find('input[name^="tarif"]').val()) || 0;
        const total = jmlLembar * tarif;
        row.find('input[name^="total"]').val(total);
    });


    function resetForm() {
        $('#npwrd').val('');
        $('#nm_wr').text('');
        $('#nama').text('');
        // $('#nik').text('');
        $('#npwrd_display').text('');
        $('#alamat_usaha').text('');
        $('#no_handphone').text('');
        $('#pemilik').text('');
        // $('input[name="pemilik"]').prop('checked', false).prop('disabled', false);
    }


    $('button[type="reset"]').click(function(e) {
        e.preventDefault();
        resetForm();
    });

    function formatNpwrd(npwrd) {
        return `R.${npwrd.charAt(1)}${npwrd.substring(2)}`;
    }
</script>

@endsection