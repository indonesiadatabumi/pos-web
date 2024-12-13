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

    .border-table {
        border-collapse: collapse;
        width: 100%;
    }

    .border-table td,
    .border-table th {
        border: 1px solid #000;
        padding: 8px;
        text-align: left;
    }
</style>

@section('content')
<section class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div>
                    <table align="left">
                        <tr>
                            <td>
                                <img src="images/bekasi.png" alt="Logo" width="75">
                            </td>
                            <td style=" font-size:large;">
                                PEMERINTAH KOTA BEKASI <br> DINAS PERHUBUNGAN
                            </td>
                        </tr>
                    </table>
                </div>
                <br>
                <table class="table no-border">
                    <thead>
                        <tr>
                            <th style="text-align:left; font-size: 16px;">{{ $billing->daftarUsaha->nama }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="text-align:left; font-size: 16px;">{{ $billing->daftarUsaha->alamat_usaha }}</td>
                        </tr>
                        <tr>
                            <td style="text-align:left; font-size: 16px;">NPWRD :
                                @php
                                $npwrd = $billing->daftarUsaha->npwrd ?? '-';
                                $formattedNpwr = $npwrd !== '-' ? substr($npwrd, 0, 1) . '.' . substr($npwrd, 1) : '-';
                                @endphp
                                {{ $formattedNpwr }}
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:left; font-size: 16px;">ID BILLING : #{{ $billing->id_billing }}</td>
                        </tr>
                    </tbody>
                </table>

                <!-- <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col"></div>
                        <div class="col-sm-4 invoice-col" align="center">
                            <h4>Nomor: <b>{{ $billing->npwrd }}/{{ $billing->tdn_register }}</b></h4>
                        </div>
                        <div class="col-sm-4 invoice-col"></div>
                    </div> -->
                <br>
                <div class="content">
                    <table class="border-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>No. Seri#</th>
                                <th>Jml Lembar</th>
                                <th>Tarif</th>
                                <th>Nilai Setor</th>
                                <th>Tanggal Setor</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                            $no = 1;
                            $totalJmlLembar = 0;
                            $totalNilaiSetor = 0;
                            @endphp
                            <tr>
                                <td>{{ $no++ }}.</td>
                                <td>{{ $billing->ssrd_no_seri }}</td>
                                <td>{{ $billing->ssrd_jml_lembar }}</td>
                                <td>{{ $billing->ssrd_tarif }}</td>
                                <td>{{ number_format($billing->ssrd_nilai_setor, 0, ',', '.') }}</td>
                                <td>{{ $billing->formatted_created_at }}</td>
                            </tr>

                            @php
                            // Add values to total variables
                            $totalJmlLembar += $billing->ssrd_jml_lembar;
                            $totalNilaiSetor += $billing->ssrd_nilai_setor;
                            @endphp
                        </tbody>

                        <tfoot>
                            <tr>
                                <td colspan="2" style="text-align: right;">Total</td>
                                <td>{{ $totalJmlLembar }}</td>
                                <td></td>
                                <td>{{ number_format($totalNilaiSetor, 0, ',', '.') }}</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- <div class="col-4 rtl">
                        <p>Bekasi, {{ now()->format('d F Y') }}</p>
                        <p style="margin-right: 40px;">a.n. Kepala Dinas
                        <p>Kepala Seksi Pelayanan</p>
                        <p>&nbsp;
                        <p>&nbsp;
                        <p>&nbsp;
                        <p>
                        <p>..................................</p>
                    </div> -->

            </div>
        </div>
    </div>
    </div>
    </div>
</section>
@endsection