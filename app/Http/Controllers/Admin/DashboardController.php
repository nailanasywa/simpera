<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Models\Peminjaman;
use App\Models\PermintaanPeminjaman;
use App\Models\Poli;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
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

        // Filter bulan
        $bulan = $request->get('bulan', 'all');

        // Data grafik rekam medis tepat waktu dan terlambat per poli
        $polis = Poli::orderBy('nama_poli')->get();

        $tepatWaktu = [];
        $terlambat = [];

        foreach ($polis as $poli) {

            $query = Peminjaman::where(
                'status_peminjaman',
                'selesai'
            )
                ->whereHas('kunjungan', function ($query) use ($poli) {
                    $query->where('poli_id', $poli->id);
                })
                ->whereNotNull('tanggal_kembali');

            // Jika memilih bulan tertentu
            if ($bulan !== 'all') {
                $query->whereMonth('tanggal_kembali', $bulan);
            }

            // Tepat waktu
            $tepatWaktu[] = (clone $query)
                ->whereColumn(
                    'tanggal_kembali',
                    '<=',
                    'tanggal_jatuh_tempo'
                )
                ->count();

            // Terlambat
            $terlambat[] = (clone $query)
                ->whereColumn(
                    'tanggal_kembali',
                    '>',
                    'tanggal_jatuh_tempo'
                )
                ->count();
        }

        return view('admin.dashboard', [
            'totalPasien'       => $totalPasien,
            'rmDipinjam'        => $rmDipinjam,
            'approvalPending'   => $approvalPending,
            'totalSelesai'      => $totalSelesai,
            'peminjamanTerbaru' => $peminjamanTerbaru,
            'approvalTerbaru'   => $approvalTerbaru,

            // Data grafik
            'polis'             => $polis,
            'tepatWaktu'        => $tepatWaktu,
            'terlambat'         => $terlambat,
            'bulan'             => $bulan
        ]);
    }
}
