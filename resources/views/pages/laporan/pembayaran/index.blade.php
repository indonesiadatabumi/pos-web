@extends('layouts.default')

@section('title', 'Laporan Pembayaran')

@push('css')
<link href="/assets/plugins/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
<link href="/assets/plugins/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" />
<link href="/assets/plugins/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<style>
    body {
        font-family: 'Poppins', sans-serif;
    }

    table {
        font-size: 12px;
    }
</style>
@endpush

@push('scripts')
<script src="/assets/plugins/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="/assets/plugins/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script src="/assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="/assets/plugins/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="/assets/plugins/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js"></script>
<script src="/assets/plugins/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="/assets/plugins/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="/assets/plugins/pdfmake/build/pdfmake.min.js"></script>
<script src="/assets/plugins/pdfmake/build/vfs_fonts.js"></script>
<script>
    $(document).ready(function() {
        $('#data-table-buttons').DataTable({
            responsive: true,
            dom: '<"row"<"col-sm-12 col-md-6"B><"col-sm-12 col-md-6"f>>t<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            buttons: [{
                    extend: 'copy',
                    className: 'btn-sm'
                },
                {
                    extend: 'csv',
                    className: 'btn-sm'
                },
                {
                    extend: 'excel',
                    className: 'btn-sm'
                },
                {
                    extend: 'pdf',
                    className: 'btn-sm'
                },
                {
                    extend: 'print',
                    className: 'btn-sm'
                }
            ],
        });
    });
</script>
@endpush

@section('content')
<ol class="breadcrumb float-xl-end">
    <li class="breadcrumb-item"><a href="#">Laporan</a></li>
    <li class="breadcrumb-item active">Laporan Pembayaran</li>
</ol>

<!-- END breadcrumb -->
<!-- BEGIN page-header -->
<h1>Laporan Pembayaran</h1>
<!-- END page-header -->
<!-- BEGIN row -->
<div class="row">
    <!-- BEGIN col-2 -->
    <!-- END col-2 -->
    <!-- BEGIN col-10 -->
    <div class="col-xl-12">
        <!-- BEGIN panel -->
        <div class="panel panel-default">
            <!-- BEGIN panel-heading -->
            <div class="panel-heading">
                <i class="fas fa-sign-in-alt icon"></i>
                <div class="title">Daftar Pembayaran</div>
            </div>

            <div class="panel panel-default mt-3">
                <div class="panel-body">
                    <table id="data-table-buttons" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>NPWRD</th>
                                <th>Nama</th>
                                <th>ID Billing</th>
                                <th>Jumlah Pembayaran</th>
                                <th>Tanggal Pembayaran</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($billings as $billing)
                            <tr>
                                <td>{{ $loop->iteration }}.</td>
                                <td>
                                    @php
                                    $npwrd = $billing->npwrd;
                                    $formattedNpwr = substr($npwrd, 0, 1) . '.' . substr($npwrd, 1);
                                    @endphp
                                    {{ $formattedNpwr }}
                                </td>
                                <td>{{ $billing->daftarUsaha->nama ?? '-' }}</td>
                                <td>{{ $billing->id_billing }}</td>
                                <td>Rp {{ number_format($billing->ssrd_nilai_setor, 0, ',', '.') }}</td>
                                <td>{{ $billing->created_at }}</td>
                                <td>{{ $billing->status }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        @endsection