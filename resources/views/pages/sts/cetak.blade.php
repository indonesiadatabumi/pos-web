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
                <th width="38%" style="text-align: right;"><img src="images/kutai.png" alt="Logo" height="130"></th>
                <th style="text-align: center;">
                    <div style="text-align: left; padding-left: 0px;">
                        <h2>PEMERINTAH KAB. KUTAI KARTANEGARA<br>Badan Pendapatan Daerah</h2>
                        <p>Jl. Yos Sudarso No.117</p>
                    </div>
                </th>
            </tr>
        </table>

        <hr style="border: 0.5px solid black; margin-top: 10px; opacity: 0.2;">
        <h2 style="text-align: center;">REKAP SURAT TANDA SETORAN</h2>

        <table class="table-rekap-sts">
            <thead>
                <tr>
                    <th width="1%">No.</th>
                    <th class="text-nowrap">NPWRD</th>
                    <th class="text-nowrap">NAMA</th>
                    <th class="text-nowrap">ID BILLING</th>
                    <th class="text-nowrap">TGL SETOR</th>
                    <th class="text-nowrap">JUMLAH SETORAN</th>
            </thead>
            <tbody>
                @php
                $no = 1; // Inisialisasi variabel penomoran
                @endphp

                @foreach($billings as $billing)
                <tr class="{{ $loop->even ? 'even' : 'odd' }} gradeX">
                    <td width="1%" class="fw-bold text-dark">{{ $no++ }}</td>
                    <td>{{ $billing->npwrd}}</td>
                    <td>{{ $billing->daftarUsaha_nama}}</td>
                    <td>{{ $billing->id_billing }}</td>
                    <td>{{ $billing->created_at}}</td>
                    <td>Rp {{ number_format($billing->ssrd_nilai_setor, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div>
</body>

</html>