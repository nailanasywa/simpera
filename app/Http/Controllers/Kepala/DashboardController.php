<?php

namespace App\Http\Controllers\Kepala;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $totalPasien = Pasien::count();
        $totalPeminjaman = Peminjaman::count();
        $dipinjam = Peminjaman::where('status_peminjaman', 'dipinjam')->count();
        $selesai = Peminjaman::where('status_peminjaman', 'selesai')->count();
        $tepatWaktu = Peminjaman::where('status_peminjaman', 'selesai')->where('jumlah_hari_terlambat', 0)->count();
        $terlambat = Peminjaman::where('status_peminjaman', 'selesai')->where('jumlah_hari_terlambat', '>', 0)->count();
        $peminjamanTerbaru = Peminjaman::with([
            'pasien',
            'kunjungan.poli',
            'permintaan.user.poli'
        ])->latest()->take(5)->get();

        return view('kepala.dashboard', [
            'totalPasien'       => $totalPasien,
            'totalPeminjaman'   => $totalPeminjaman,
            'dipinjam'          => $dipinjam,
            'selesai'           => $selesai,
            'tepatWaktu'        => $tepatWaktu,
            'terlambat'         => $terlambat,
            'peminjamanTerbaru' => $peminjamanTerbaru
        ]);
    }
}
