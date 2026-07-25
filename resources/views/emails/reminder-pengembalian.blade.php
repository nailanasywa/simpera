<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Reminder Pengembalian Rekam Medis</title>
</head>

<body>

    <h2>Pengingat Pengembalian Rekam Medis</h2>

    <p>Yth. <strong>{{ $peminjaman->pasien->nama_pasien }}</strong>,</p>

    <p>
        Kami mengingatkan bahwa berkas rekam medis dengan rincian berikut
        masih dalam status <strong>dipinjam</strong>.
    </p>

    <table cellpadding="6" cellspacing="0" border="1">
        <tr>
            <td><strong>No. Rekam Medis</strong></td>
            <td>{{ $peminjaman->pasien->no_rm }}</td>
        </tr>

        <tr>
            <td><strong>Tanggal Pinjam</strong></td>
            <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d-m-Y H:i') }}</td>
        </tr>

        <tr>
            <td><strong>Jatuh Tempo</strong></td>
            <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_jatuh_tempo)->format('d-m-Y H:i') }}</td>
        </tr>

        <tr>
            <td><strong>Status</strong></td>
            <td>{{ ucfirst($peminjaman->status_peminjaman) }}</td>
        </tr>
    </table>

    <br>

    <p>
        Mohon segera mengembalikan berkas rekam medis tersebut kepada Unit Rekam Medis
        agar pelayanan tetap berjalan dengan baik.
    </p>

    <p>
        Terima kasih atas perhatian dan kerja samanya.
    </p>

    <hr>

    <small>
        Email ini dikirim secara otomatis oleh Sistem Informasi Peminjaman dan Pengembalian Rekam Medis (SIMPERA).
    </small>

</body>

</html>
