<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Poli;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use App\Exports\LaporanExport;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index(Request $request) {
        // data master poli
        $polis = Poli::orderBy('nama_poli')->get();

        // query dasar
        $query = Peminjaman::with([
            'pasien',
            'kunjungan.poli',
            'permintaan.user.poli'
        ])->where('status_peminjaman', 'selesai');

        // terapkan filter
        $this->applyFilter($query, $request);

        // tabel laporan
        $laporans = (clone $query)->latest()->get();

        // total data
        $total = (clone $query)->count();

        // card rekap poli
        $rekapPoli = [];

        if ($request->filled('poli_id')) {
            $poli = Poli::find($request->poli_id);
            $rekapPoli[] = [
                'nama'      => $poli->nama_poli,
                'jumlah'    => $total,
            ];
        } else {
            foreach ($polis as $poli) {
                $cardQuery = Peminjaman::with([
                    'kunjungan',
                    'permintaan.user'
                ])->where('status_peminjaman', 'selesai');

                $this->applyFilter($cardQuery, $request);

                $cardQuery->where(function ($q) use ($poli) {
                    $q->whereHas('kunjungan', function ($sub) use ($poli) {
                        $sub->where('poli_id', $poli->id);
                    })->orWhereHas('permintaan.user', function ($sub) use ($poli) {
                        $sub->where('poli_id', $poli->id);
                    });
                });

                $rekapPoli[] = [
                    'nama'      => $poli->nama_poli,
                    'jumlah'    => $cardQuery->count(),
                ];
            }
        }

        $routePrefix = auth()->user()->role == 'admin' ? 'admin' : 'kepala';

        return view('admin.laporan', [
            'polis'     => $polis,
            'laporans'  => $laporans,
            'rekapPoli' => $rekapPoli,
            'total'     => $total,
            'routePrefix' => $routePrefix
        ]);
    }

    public function export(Request $request) {
        return Excel::download(
            new LaporanExport($request), 'laporan-peminjaman.xlsx'
        );
    }

    private function applyFilter($query, Request $request) {
        // filter jenis
        if ($request->filled('jenis_peminjaman')) {
            $query->where('jenis_peminjaman', $request->jenis_peminjaman);
        }

        // filter poli
        if ($request->filled('poli_id')) {
            $query->where(function ($q) use ($request) {
                $q->whereHas('kunjungan', function ($sub) use ($request) {
                    $sub->where('poli_id', $request->poli_id);
                })->orWhereHas('permintaan.user', function ($sub) use ($request) {
                    $sub->where('poli_id', $request->poli_id);
                });
            });
        }

        // filter rentang waktu
        if ($request->filled('filter')) {
            switch ($request->filter) {
                // hari ini
                case 'hari_ini' :
                    $query->whereDate('tanggal_pinjam', today());
                break;

                // 7 hari terakhir
                case '7_hari' :
                    $query->whereBetween('tanggal_pinjam', [
                        now()->subDays(6)->startOfDay(), now()->endOfDay()
                    ]);
                break;

                // pilih bulan
                case 'bulan' :
                    if ($request->filled('bulan')) {
                        $query->whereMonth(
                            'tanggal_pinjam', $request->bulan
                        );
                    }
                break;

                // rentang tanggal
                case 'tanggal' :
                    if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
                        $query->whereBetween('tanggal_pinjam', [
                            $request->tanggal_awal.' 00:00:00',
                            $request->tanggal_akhir.' 23:59:59'
                        ]);
                    }
                break;
            }
        }
    }
}
