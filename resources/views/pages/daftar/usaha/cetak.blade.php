@extends('layouts.empty')

@section('title', 'Cetak Surat Keterangan Terdaftar')

<style>
    .rtl {
        direction: rtl;

        line-height: 5px;
    }

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

@section('content')
<section class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div>
                    <table align="center">
                        <tr>
                            <td>
                                <img src="images/kutai.png" alt="Logo" width="75">
                            </td>
                            <td>
                                <h3>
                                    <b>PEMERINTAH KOTA KUTAI KARTANEGARA <br> DINAS PERHUBUNGAN</b>
                                    <br>KOTA KUTAI KARTANEGARA
                                </h3>
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="invoice p-3 mb-3">
                    <div class="row">
                        <div class="col-12" align="center">
                            <h4>SURAT KETERANGAN TERDAFTAR</h4>
                            <h4>Nomor: <b>{{ $usaha->npwrd }}/{{ now()->format('y') }}</b></h4>
                        </div>
                    </div>

                    <!-- <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col"></div>
                        <div class="col-sm-4 invoice-col" align="center">
                            <h4>Nomor: <b>{{ $usaha->npwrd }}/{{ $usaha->tdn_register }}</b></h4>
                        </div>
                        <div class="col-sm-4 invoice-col"></div>
                    </div> -->

                    <div class="row">
                        <div class="col-sm-12 invoice-col">
                            <p class="lead">
                                Sesuai dengan Pasal 1 ayat (13) PERDA No. 3 Tahun 2020 Tentang Penyelenggaraan Parkir Tepi jalan, dengan ini diterangkan bahwa:
                            </p>
                        </div>
                    </div>

                    <div class="row invoice-info">
                        <div class="col-sm-12 invoice-col">
                            <table class="table">
                                <tr>
                                    <td>1.</td>
                                    <td>Nama Wajib Retribusi</td>
                                    <td>:</td>
                                    <td>{{ $usaha->nm_wr }}</td>
                                </tr>
                                <tr>
                                    <td>2.</td>
                                    <td>Nomor Pokok Wajib Retribusi (NPWRD)</td>
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
                                    <td>3.</td>
                                    <td>Nama Pengelola/Usaha/OPD</td>
                                    <td>:</td>
                                    <td>{{ $usaha->nama }}</td>
                                </tr>
                                <tr>
                                    <td>4.</td>
                                    <td>Alamat Usaha</td>
                                    <td>:</td>
                                    <td>{{ $usaha->alamat_usaha }}</td>
                                </tr>
                                <tr>
                                    <td>5.</td>
                                    <td>No HP</td>
                                    <td>:</td>
                                    <td>{{ $usaha->no_handphone }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-8">
                            <p class="lead">
                                Telah Terdaftar pada administrasi kami terhitung sejak tanggal {{ $usaha->tanggal_terdaftar }}
                            </p>
                        </div>
                        <div class="col-4 rtl">
                            <p>Bekasi, {{ now()->format('d F Y') }}</p>
                            <p style="margin-right: 40px;">a.n. Kepala Dinas
                            <p>Kepala Seksi Pelayanan</p>
                            <p>&nbsp;
                            <p>&nbsp;
                            <p>&nbsp;
                            <p>
                            <p>..................................</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection