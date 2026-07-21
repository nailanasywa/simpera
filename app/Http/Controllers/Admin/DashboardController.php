<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Models\Peminjaman;
use App\Models\PermintaanPeminjaman;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $totalPasien = Pasien::count();
        $rmDipinjam = Peminjaman::where('status_peminjaman', 'dipinjam')->count();
        $approvalPending = PermintaanPeminjaman::where(
            'status_approval',
            'pending'
        )->count();

        $totalSelesai = Peminjaman::where(
            'status_peminjaman',
            'selesai'
        )->count();

        $peminjamanTerbaru = Peminjaman::with([
            'pasien',
            'kunjungan.poli',
            'permintaan.user.poli'
        ])->latest()->take(5)->get();

        $approvalTerbaru = PermintaanPeminjaman::with([
            'pasien',
            'user.poli'
        ])->where('status_approval', 'pending')->latest()->take(5)->get();

        return view('admin.dashboard', [
            'totalPasien'       => $totalPasien,
            'rmDipinjam'        => $rmDipinjam,
            'approvalPending'   => $approvalPending,
            'totalSelesai'      => $totalSelesai,
            'peminjamanTerbaru' => $peminjamanTerbaru,
            'approvalTerbaru'   => $approvalTerbaru
        ]);
    }
}
