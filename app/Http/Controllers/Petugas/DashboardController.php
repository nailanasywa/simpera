<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\PermintaanPeminjaman;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $user = auth()->user();
        $totalPermintaan = PermintaanPeminjaman::where('user_id', $user->id)->count();
        $pending = PermintaanPeminjaman::where('user_id', $user->id)->where('status_approval', 'pending')->count();
        $disetujui = PermintaanPeminjaman::where('user_id', $user->id)->where('status_approval', 'disetujui')->count();
        $permintaanTerbaru = PermintaanPeminjaman::with('pasien')
            ->where('user_id', $user->id)->latest()->take(5)->get();

        return view('petugas.dashboard', [
            'totalPermintaan'       => $totalPermintaan,
            'pending'               => $pending,
            'disetujui'             => $disetujui,
            'permintaanTerbaru'     => $permintaanTerbaru
        ]);
    }
}
