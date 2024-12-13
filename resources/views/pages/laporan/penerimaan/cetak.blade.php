<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Surat Tanda Setoran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .header,
        .footer {
            text-align: center;
        }

        .content {
            margin: 0 auto;
            width: 100%;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            border: 0px solid black;
            padding: 10px;
            text-align: center;
        }

        .table-rekap-sts {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-family: Arial, sans-serif;
        }

        .table-rekap-sts th,
        .table-rekap-sts td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }

        .table-rekap-sts th {
            background-color: #ffff;
            font-weight: bold;
        }

        .table-rekap-sts td {
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="content">
        <table class="table">
            <tr>
                <th width="38%" style="text-align: right;"><img src="images/bekasi.png" alt="Logo" height="130"></th>
                <th style="text-align: center;">
                    <div style="text-align: left; padding-left: 0px;">
                        <h2>PEMERINTAH KAB. BEKASI<br>Badan Pendapatan Daerah</h2>
                        <p>Jl. Yos Sudarso No.117</p>
                    </div>
                </th>
            </tr>
        </table>

        <hr style="border: 0.5px solid black; margin-top: 10px; opacity: 0.2;">
        <h2 style="text-align: center;">TANDA SETORAN</h2>

        <p>No. STS: {{ $billings->id_billing }}</p>
        <p>Dari: {{ $billings->daftarUsaha_nama }}</p>
        <p>Kepada: Badan Pendapatan Daerah</p>
        <p>Tanggal Setor: {{ $billings->formatted_created_at }}</p>

        <table class="table-rekap-sts">
            <thead>
                <tr>
                    <th width="1%">No.</th>
                    <th class="text-nowrap">NO. SERI</th>
                    <th class="text-nowrap">NOMOR AWAL</th>
                    <th class="text-nowrap">NOMOR AKHIR</th>
                    <th class="text-nowrap">LEMBAR DISETOR</th>
                    <th class="text-nowrap">TARIF</th>
                    <th class="text-nowrap">JUMLAH SETOR</th>
            </thead>
            <tbody>
                <tr>
                    <td width="1%" class="fw-bold text-dark">1</td>
                    <td>{{ $billings->ssrd_no_seri}}</td>
                    <td>{{ $billings->ssrd_no_awal}}</td>
                    <td>{{ $billings->ssrd_no_akhir}}</td>
                    <td>{{ $billings->ssrd_jml_lembar}}</td>
                    <td>Rp{{ $billings->ssrd_tarif}}</td>
                    <td>Rp{{ $billings->ssrd_nilai_setor}}</td>
                </tr>

                <!-- <tr>
                    <td>Jumlah</td>
                    <td colspan="4"></td>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td>terbilang</td>
                    <td colspan="6"></td>
                </tr> -->
            </tbody>
        </table>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th colspan="3"></th>
                </tr>
            </thead>
            <tbody>
                <td width="33%">Penyetor</td>
                <td></td>
                <td>Bekasi, {{ tglIndo(now()->format('Y-m-d')) }}<br>Bendahara Penerima</td>
                <tr>
                    <td colspan="3"><br><br><br><br><br></td>
                </tr>
                <tr>
                    <td><span style="text-decoration: underline; margin-bottom: 10px;">EKO SUNU PINARDIONO</span>
                        <br>Jukir Kab. Tulungagung
                        <br>NPWRD. R.1.241200132
                    </td>
                    <td></td>
                    <td><span style="text-decoration: underline;">MAHENDRA KURNIAWAN</span>
                        <br> Pengatur Muda Tingkat I
                        <br>NIP. 19860611 200901 1 002
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>Mengetahui,
                        <br>Kasi Tata Kelola Perparkiran
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="3"><br><br><br><br><br></td>
                </tr>
                <tr>
                    <td></td>
                    <td width="40%"><span style="text-decoration: underline;">VINYAS NUGRAHANINGRUM, S.Tr, M.M</span>
                        <br>Pembina / IV A
                        <br>NIP. 19810112 200604 2 017
                    </td>
                    <td width="30%"></td>
                </tr>
            </tbody>
        </table>
    </div>
    </div>
</body>

</html>