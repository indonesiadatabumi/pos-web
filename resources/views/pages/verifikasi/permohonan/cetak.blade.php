<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permohonan Cetak</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            width: 90%;
            margin: 0 auto;
        }

        .header,
        .footer {
            text-align: center;
            margin-bottom: 20px;
        }

        .content {
            margin-top: 20px;
        }

        .row {
            display: flex;
            justify-content: space-between;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        .table th {
            background-color: #f2f2f2;
        }

        .left-align {
            text-align: left;
        }

        .right-align {
            text-align: right;
        }

        .signatures {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
        }

        .signatures div {
            text-align: center;
        }

        .print-button {
            text-align: center;
            margin-top: 20px;
        }

        .signatures1 {
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
        }

        .no-border {
            border: none;
        }

        .no-border th,
        .no-border td {
            border: none;
            text-align: left;
            font-weight: normal;
        }

        .no-border th {
            background-color: transparent;
        }

        .align-right {
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row">
            <h2>Pemerintah Kab. Tulungagung</h2>
            <strong>Pihak Pertama :</strong><br>
            <p>
                Dinas Perhubungan<br>
                Jl. Yos Sudarso No.117<br>
                Phone: (0355) 320111<br>
                Email: dishubta@gmail.com
            </p>
        </div>

        <div class="row">
            <div>
                <h4><strong>Pihak Kedua :</strong></h4>
                <p>
                    <strong>{{ strtoupper($permohonan->nm_wr) }}</strong><br>
                    {{ strtoupper($permohonan->alamat_usaha) }}<br>
                    Kelurahan {{ $permohonan->daftarUsaha->kelurahan->nm_kelurahan }} Kecamatan {{ $permohonan->daftarUsaha->kecamatan->nm_kecamatan }}<br>
                    Phone: {{ $permohonan->no_handphone }}<br>
                    Nomor: {{ $permohonan->npwrd }}/{{ now()->format('y') }}
                </p>
            </div>
            <div class="right-align">
                <p>
                    <b>No Permohonan:</b> {{ $permohonan->no_permohonan }}<br>
                    <b>Tanggal Permohonan:</b> {{ \Carbon\Carbon::parse($permohonan->formatted_created_at)->format('d-m-Y') }}<br>
                    <b>Status:</b> {{ $permohonan->status }}
                </p>
                <p>Date: {{ now()->addHours(7)->format('Y/m/d H:i:s') }}</p>
            </div>
        </div>

        <div class="content">
            <table class="table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Retribusi</th>
                        <th>No. Awal</th>
                        <th>No. Akhir</th>
                        <th>Jumlah Lembar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permohonan->details as $index => $detail)
                    <tr>
                        <td>{{ $index + 1 }}.</td>
                        <td>{{ $permohonan->nm_wr}}</td>
                        <td>{{ $detail->no_awal }}</td>
                        <td>{{ $detail->no_akhir }}</td>
                        <td>{{ $detail->jml_lembar }}</td>
                    </tr>
                    @endforeach
                </tbody>

            </table>

            <p><strong>Pernyataan:</strong><br>
                Pada hari {{ hariIndo(now()->format('l')) }}, Tanggal {{ tglIndo(now()->format('Y-m-d')) }} dengan ini menyatakan telah di serah terimakan Benda Berharga / Bundel Karcis Parkir dengan Rincian Tersebut diatas.<br>
                Demikian berita acara serah terima dibuat dan untuk dipertanggung jawabkan.</p>
            <br>
            <br>
            <!-- <div class="row">
            <div>
                <strong>Total Benda Berharga diserahkan:</strong><br>
                Total Karcis : {{ $permohonan->total_karcis }} Lembar<br>
                Total Nilai Uang: Rp. {{ number_format($permohonan->total_nilai_uang, 0, ',', '.') }}
            </div>
        </div> -->
            <!-- <div class="signatures">
    <div style="text-align: left; width: 50%;">
        <p>Yang Menyerahkan<br>Kasi Perparkiran</p>
        <br><br>
        <strong>Vinyas Nugrahaningrum, S.Tr., MM</strong><br>
        NIP: 19810112 200604 2 017
    </div> -->
            <table class="table no-border">
                <thead>
                    <tr>
                        <th style="text-align:left;">Yang Menyerahkan<br>Kasi Perparkiran</th>
                        <th style="text-align:center;">Yang Menerima</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    <tr>
                        <td style="height: 100px;"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="text-align:left;"><u>Vinyas Nugrahaningrum, S.Tr., MM</u>
                            <br> NIP: 19810112 200604 2 017
                        </td>
                        <td style="text-align:center;">{{ $permohonan->nm_wr }}</td>
                    </tr>
                </tbody>
            </table>
            <!-- <div class="signatures1">
    <div style="text-align: right; width: 100%;">
        <p>Yang Menerima</p>
        <br><br>
        <strong>{{ $permohonan->nm_wr }}</strong>
    </div>
</div> -->



            <!-- <div class="print-button">
            <button onclick="window.print()">Print</button>
        </div> -->
        </div>
    </div>

</body>

</html>