@extends('layouts.default')

@section('title', 'Lihat Daftar Usaha')

@push('css')
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

@section('content')
<!-- BEGIN breadcrumb -->
<ol class="breadcrumb float-xl-end">
    <li class="breadcrumb-item"><a href="javascript:;">Pelayanan</a></li>
    <li class="breadcrumb-item"><a href="javascript:;">Lihat Daftar Usaha</a></li>
</ol>
<!-- END breadcrumb -->

<!-- BEGIN page-header -->
<h1>Bukti Pendaftaran</h1>
<!-- END page-header -->

<!-- BEGIN panel -->
<div class="panel panel-default">
    <!-- BEGIN panel-heading -->
    <!-- END panel-heading -->

    <!-- BEGIN panel-body -->
    <div class="panel-body">
        <table class="table">
            <tr>
                <th>1.</th>
                <th>Nama Wajib Retribusi</th>
                <td>:</td>
                <td>{{ $usaha->nm_wr }}</td>
            </tr>
            <tr>
                <th>2.</th>
                <th>Nomor Pokok Wajib Retribusi (NPWRD)</th>
                <td>:</td>
                <td>
                    @php
                    $npwrd = $usaha->npwrd;
                    $formattedNpwr = substr($npwrd, 0, 1) . '.' . substr($npwrd, 1);
                    @endphp
                    {{ $formattedNpwr }}
                </td>
            </tr>
            <tr>
                <th>3.</th>
                <th>Nama Pengelola/Usaha/OPD</th>
                <td>:</td>
                <td>{{ $usaha->nama }}</td>
            </tr>
            <tr>
                <th>4.</th>
                <th>Jenis Retribusi</th>
                <td>:</td>
                <td>{{ $usaha->jenis_retribusi->nm_retribusi }}</td>
            </tr>
            <tr>
                <th>5.</th>
                <th>Alamat Usaha</th>
                <td>:</td>
                <td>{{ $usaha->alamat_usaha }}</td>
            </tr>
            <tr>
                <th>6.</th>
                <th>No HP</th>
                <td>:</td>
                <td>{{ $usaha->no_handphone }}</td>
            </tr>
            <tr>
                <th>7.</th>
                <th>Foto KTP</th>
                <td>:</td>
                <td>
                    @if($usaha->foto)
                    <img src="{{ asset('storage/foto/' . $usaha->foto) }}" alt="Foto KTP" width="250">
                    @else
                    Tidak ada foto yang tersedia
                    @endif
                </td>
            </tr>
        </table>

        <a href="{{ route('pages.daftar.usaha.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
    <!-- END panel-body -->
</div>
<!-- END panel -->
@endsection