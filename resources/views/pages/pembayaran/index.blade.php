@extends('layouts.default')

@section('title', 'PEMBAYARAN BILLING')

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

@if(session('pembayaran_berhasil'))
<script>
    Swal.fire({
        title: 'Pembayaran Berhasil!',
        text: '{{ session('
        pembayaran_berhasil ') }}',
        icon: 'success',
        confirmButtonText: 'OK'
    });
</script>
@endif

@endpush

@section('content')
<!-- BEGIN Breadcrumb -->
<ol class="breadcrumb float-xl-end">
    <li class="breadcrumb-item"><a href="javascript:;">Pembayaran</a></li>
    <li class="breadcrumb-item"><a href="javascript:;">Pembayaran Billing</a></li>
</ol>
<h1>PEMBAYARAN BILLING</h1>
<!-- END page-header -->
<!-- BEGIN panel -->
<div class="panel panel-default">
    <!-- BEGIN panel-heading -->
    <div class="panel-heading">
        <i class="fas fa-sign-in-alt icon"></i>
        <div class="title">Daftar Billing</div>
    </div>
    <!-- END panel-heading -->
    <!-- BEGIN panel-body -->
    @php
    $userRoleId = auth()->user()->role_id;
    @endphp

    <div class="container-fluid mt-3">
        <form id="pembayaranForm" action="{{ route('pembayaran.store') }}" method="POST">
            @csrf
            <div class="form-group row align-items-center">
                <label for="id_billing" class="col-sm-1 col-form-label fw-bold">ID Billing</label>
                <div class="col-sm-6">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-user"></i>
                        </span>
                        <select name="id_billing" id="id_billing" class="form-control custom-select shadow-sm" required>
                            <option value="" selected disabled>-- Pilih Billing --</option>
                            @foreach ($billings as $billing)
                            <option value="{{ $billing->id_billing }}">{{ $billing->id_billing }} - {{ $billing->daftarUsaha->nama ?? '-' }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="card p-3" style="background: #DEE1E6;">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4>Informasi Billing</h4>
                            <b><strong>Tanggal: </strong><span id="currentDate"></span></b>
                        </div>
                        <br>
                        <h2>
                            <b>Nama : <span id="nama" name="nama"></span></b>
                        </h2>
                        <br>
                        <h2>
                            <b>NPWRD : <span id="npwrd" name="npwrd"></span></b>
                        </h2>
                        <br>
                        <h5>
                            <p><strong>No. Seri :</strong> <span
                                    id="ssrd_no_seri" name="ssrd_no_seri"></span></p>
                        </h5>
                        <h5>
                            <p><strong>No. Awal :</strong> <span
                                    id="ssrd_no_awal" name="ssrd_no_awal"></span></p>
                        </h5>
                        <h5>
                            <p><strong>No. Akhir :</strong> <span
                                    id="ssrd_no_akhir" name="ssrd_no_akhir"></span></p>
                        </h5>
                        <h5>
                            <p><strong>Jumlah Setor :</strong> <span
                                    id="ssrd_jml_setor" name="ssrd_jml_setor"></span></p>
                        </h5>
                        <h5>
                            <p><strong>Nilai Setor :</strong> <span
                                    id="ssrd_nilai_setor" name="ssrd_nilai_setor"></span></p>
                        </h5>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-3">
                    <button type="reset" class="btn btn-danger me-2">Reset</button>
                    <button type="submit" class="btn btn-primary">Bayar</button>
                </div>
            </div>
            <br>
        </form>
    </div>
</div>

<script type="module">
    $(document).ready(function() {
        $('#id_billing').select2({
            placeholder: '-- Pilih Billing --',
            allowClear: true,
            width: 'resolve'
        });

        const date = new Date();
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const year = date.getFullYear();
        document.getElementById('currentDate').textContent = `${day}/${month}/${year}`;

        $('#id_billing').change(function() {
            const id_billing = $(this).val();

            if (id_billing) {
                $.ajax({
                    url: `/pembayaran/get-data/${id_billing}`,
                    method: 'GET',
                    success: function(data) {
                        if (data) {
                            $('#nama').text(data.nama);
                            const formattedNpwrd = data.npwrd.replace(/^(.)(.*)$/, '$1.$2');
                            $('#npwrd').text(formattedNpwrd);
                            $('#ssrd_no_seri').text(data.ssrd_no_seri);
                            $('#ssrd_no_awal').text(data.ssrd_no_awal);
                            $('#ssrd_no_akhir').text(data.ssrd_no_akhir);
                            $('#ssrd_jml_setor').text(data.ssrd_jml_lembar);
                            $('#ssrd_nilai_setor').text(data.ssrd_nilai_setor);

                            $('#ssrd_nilai_setor').text('Rp ' + new Intl.NumberFormat('id-ID').format(data.ssrd_nilai_setor));
                        } else {
                            console.error("Data billing tidak ditemukan.");
                        }
                    },
                    error: function(jqXHR) {
                        console.error("Terjadi kesalahan dalam mengambil data billing.", jqXHR);
                    }
                });
            } else {
                resetForm();
            }
        });
    });

    function resetForm() {
        $('#nama').text('');
        $('#npwrd').text('');
        $('#ssrd_no_awal').text('');
        $('#ssrd_no_akhir').text('');
        $('#ssrd_jml_setor').text('');
        $('#ssrd_nilai_setor').text('');

        $('input[name="nama"]').val('');
        $('input[name="npwrd"]').val('');
        $('input[name="ssrd_no_awal"]').val('');
        $('input[name="ssrd_no_akhir"]').val('');
        $('input[name="ssrd_jml_setor"]').val('');
        $('input[name="ssrd_nilai_setor"]').val('');
    }

    $('button[type="reset"]').click(function(e) {
        e.preventDefault();
        resetForm();
    });
</script>

@endsection