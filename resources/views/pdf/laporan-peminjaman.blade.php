<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <table style="width:100%; border:none; border-bottom:3px solid black; padding-bottom:8px;">
        <tr>
            <td style="width:15%; border:none; text-align:center;">
                <img src="{{ public_path('logokabjember.png') }}" width="80">
            </td>

            <td style="width:85%; border:none; text-align:center;">

                <div style="font-size:16px; font-weight:bold;">
                    PEMERINTAH KABUPATEN JEMBER
                </div>

                <div style="font-size:15px; font-weight:bold;">
                    DINAS KESEHATAN
                </div>

                <div style="font-size:18px; font-weight:bold;">
                    UPTD PUSKESMAS PANTI
                </div>

                <div style="font-size:11px;">
                    Jl. PB Sudirman No. 85 Panti, Jember, Jawa Timur 68153
                </div>

                <div style="font-size:11px;">
                    Telepon (0331) 711700,
                    Pos-el: uptpuskesmaspanti@gmail.com
                </div>

            </td>
        </tr>
    </table>

    <br>

    <table style="width:100%; border:none; margin-bottom:20px;">
        <tr>
            <td style="border:none; text-align:center;">
                <strong style="font-size:18px;">
                    <u>SURAT KETERANGAN</u>
                </strong>
                <br>
                Nomor:
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/
                {{ date('Y') }}
            </td>
        </tr>
    </table>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 6px;
        }

        th {
            background: #f2f2f2;
        }
    </style>
</head>

<body>

    <h2>LAPORAN PEMINJAMAN REKAM MEDIS</h2>

    <table style="border:none">
        <tr>
            <td style="border:none;width:120px;">Periode</td>
            <td style="border:none;">: {{ $periode }}</td>
        </tr>

        <tr>
            <td style="border:none;">Jenis</td>
            <td style="border:none;">: {{ $jenis }}</td>
        </tr>

        <tr>
            <td style="border:none;">Poli</td>
            <td style="border:none;">: {{ $namaPoli }}</td>
        </tr>
    </table>

    <br>

    <h4>Ringkasan</h4>

    <table>

        <tr>
            <th>Keterangan</th>
            <th>Jumlah</th>
        </tr>

        <tr>
            <td>Total Peminjaman</td>
            <td>{{ $total }}</td>
        </tr>

        <tr>
            <td>Peminjaman Kunjungan</td>
            <td>{{ $totalKunjungan }}</td>
        </tr>

        <tr>
            <td>Peminjaman Non Kunjungan</td>
            <td>{{ $totalNonKunjungan }}</td>
        </tr>

        <tr>
            <td>Tepat Waktu</td>
            <td>{{ $totalTepatWaktu }}</td>
        </tr>

        <tr>
            <td>Terlambat</td>
            <td>{{ $totalTerlambat }}</td>
        </tr>

    </table>

    <br>

    <h4>Rekap Per Poli</h4>

    <table>

        <tr>
            <th>Poli</th>
            <th>Jumlah</th>
        </tr>

        @foreach ($rekapPoli as $item)
            <tr>
                <td>{{ $item['nama'] }}</td>
                <td>{{ $item['jumlah'] }}</td>
            </tr>
        @endforeach

    </table>
    <br><br><br>

    <table style="width:100%; border:none;">
        <tr>
            <td style="width:55%; border:none;"></td>

            <td style="width:45%; border:none; text-align:center;">
                Jember, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
                <br>
                Kepala UPTD Puskesmas Panti
                <br><br><br><br><br>

                <strong><u>NUR FALAKHIS SHOIMA, M.P.H</u></strong>
                <br>
                NIP. 197509112007012022
            </td>
        </tr>
    </table>

</body>

</html>
