@extends('layouts.default')

@section('title', 'LAPORAN PERMOHONAN')

@push('css')
<link href="/assets/plugins/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
<link href="/assets/plugins/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" />
<link href="/assets/plugins/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css" rel="stylesheet" />

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
        font-size: 12px;
    }
</style>

@endpush

@push('scripts')
<script src="/assets/plugins/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="/assets/plugins/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script src="/assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="/assets/plugins/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
<script src="/assets/plugins/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="/assets/plugins/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js"></script>
<script src="/assets/plugins/datatables.net-buttons/js/buttons.colVis.min.js"></script>
<script src="/assets/plugins/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="/assets/plugins/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="/assets/plugins/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="/assets/plugins/pdfmake/build/pdfmake.min.js"></script>
<script src="/assets/plugins/pdfmake/build/vfs_fonts.js"></script>
<script src="/assets/plugins/jszip/dist/jszip.min.js"></script>
<script src="/assets/js/demo/table-manage-buttons.demo.js"></script>
<script src="/assets/plugins/@highlightjs/cdn-assets/highlight.min.js"></script>
<script src="/assets/js/demo/render.highlight.js"></script>
@endpush

@section('content')
<!-- BEGIN breadcrumb -->
<ol class="breadcrumb float-xl-end">
    <li class="breadcrumb-item"><a href="javascript:;">Laporan</a></li>
    <li class="breadcrumb-item"><a href="javascript:;">Laporan Permohonan</a></li>
</ol>
<!-- END breadcrumb -->
<!-- BEGIN page-header -->
<h1>Laporan Permohonan</h1>
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
                <div class="title">Daftar Permohonan</div>
            </div>
            <div class="container-fluid mt-3">
                <div class="row mb-3">
                    <div class="col-xs-6 col-sm-2">
                        <div class="d-flex flex-column align-items-start">
                            <form method="GET" action="{{ route('pages.laporan.permohonan.index') }}">
                                <label for="wajibRetribusi" class="form-label me-2 mb-3">Tanggal Awal :</label>
                                <div>
                                    <div class="input-group-date" id="searchStartDate" data-target-input="nearest">
                                        <input type="date" class="form-control datetimepicker-input StartDate" id="StartDate" maxlength="10" placeholder="yyyy-mm-dd" data-target="#searchStartDate">
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-3">
                        <div class="d-flex flex-column align-items-start">
                            <label for="wajibRetribusi" class="form-label me-1 mb-3">Tanggal Akhir :</label>
                            <div>
                                <div class="input-group-date" id="searchEndDate" data-target-input="nearest">
                                    <input type="date" class="form-control datetimepicker-input Endate" id="EtartDate" maxlength="10" placeholder="yyyy-mm-dd" data-target="#searchEndDate">
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- BEGIN panel-heading -->
            <!-- BEGIN panel-body -->
            <div class="panel-body">
                <table id="data-table-buttons" class="table table-striped table-bordered align-middle">
                    <thead>
                        <tr>
                            <th width="1%">NO.</th>
                            <th class="text-nowrap">NPWRD</th>
                            <th class="text-nowrap">NAMA WAJIB RETRIBUSI</th>
                            <th class="text-nowrap">ALAMAT USAHA</th>
                            <th class="text-nowrap">NO. AWAL</th>
                            <th class="text-nowrap">NO. AKHIR</th>
                            <th class="text-nowrap">JUMLAH LEMBAR</th>
                            <th class="text-nowrap">TANGGAL PERMOHONAN</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($laporanPermohonan as $index => $permohonan)
                        <tr>
                            <td>{{ $index + 1 }}.</td>
                            <td>
                                @php
                                $npwrd = $permohonan->npwrd;
                                $formattedNpwr = substr($npwrd, 0, 1) . '.' . substr($npwrd, 1);
                                @endphp
                                {{ $formattedNpwr }}
                            </td>

                            <td>{{ $permohonan->nm_wr }}</td>
                            <td>{{ $permohonan->alamat_usaha }}</td>
                            <td>{{ $permohonan->no_awal }}</td>
                            <td>{{ $permohonan->no_akhir }}</td>
                            <td>{{ $permohonan->jml_lembar }}</td>
                            <td>{{ \Carbon\Carbon::parse($permohonan->tanggal_permohonan)->format('d-m-Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
            <!-- END panel-body -->
            <!-- BEGIN hljs-wrapper -->
            <script>
                $('#data-table-default').DataTable({
                    responsive: true,
                    dom: '<"row"<"col-sm-5"B><"col-sm-7"fr>>t<"row"<"col-sm-5"i><"col-sm-7"p>>',
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
            </script>
        </div>
        <!-- END hljs-wrapper -->
    </div>
    <!-- END panel -->
</div>
<!-- END col-10 -->
</div>
<!-- END row -->
@endsection