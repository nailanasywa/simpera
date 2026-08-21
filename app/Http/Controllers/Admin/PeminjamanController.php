<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Pasien;
use App\Models\Poli;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with([
            'pasien',
            'kunjungan.poli',
            'permintaan.user.poli'
        ])->where('status_peminjaman', 'dipinjam');

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

        // filter jenis peminjaman
        if ($request->filled('jenis_peminjaman')) {
            $query->where('jenis_peminjaman', $request->jenis_peminjaman);
        }

        // validasi filter don't barengan
        if ($request->filled('hari_ini') && (
            $request->filled('tanggal_awal') ||
            $request->filled('tanggal_akhir')
        )) {
            return redirect()->route('admin.peminjaman')->with('error', 'Filter hari ini tidak dapat digunakan bersamaan dengan Rentang Tanggal.');
        }
        if ($request->filled('tanggal_awal') xor $request->filled('tanggal_akhir')) {
            return redirect()->route('admin.peminjaman')->with('error', 'Tanggal Awal dan Tanggal Akhir harus diisi keduanya.');
        }
        // filter hari ini
        if ($request->filled('hari_ini')) {
            $query->whereDate('tanggal_pinjam', now()->toDateString());
        }
        // filter tanggal (option kalau tidak centang hari ini)
        elseif ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal_pinjam', '>=', $request->tanggal_awal);
            $query->whereDate('tanggal_pinjam', '<=', $request->tanggal_akhir);
        }
        // validasi tanggal
        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            if ($request->tanggal_awal > $request->tanggal_akhir) {
                return redirect()->route('admin.peminjaman')->with('error', 'Tanggal Akhir tidak boleh lebih kecil dari Tanggal Awal');
            }
        }

        // show data
        $peminjamans = $query->latest()->get();
        $totalData = $peminjamans->count();
        $polis = Poli::orderBy('nama_poli')->get();

        return view('admin.transaksi.peminjaman', [
            'peminjamans'   => $peminjamans,
            'polis'         => $polis,
            'totalData'     => $totalData
        ]);
    }

    public function pinjamSelesai(Peminjaman $peminjaman)
    {
        $tanggalKembali = now();

        // hitung keterlambatan
        $terlambat = 0;
        if ($tanggalKembali->gt($peminjaman->tanggal_jatuh_tempo)) {
            $terlambat = Carbon::parse(
                $peminjaman->tanggal_jatuh_tempo
            )->diffInDays($tanggalKembali);
        }

        // update peminjaman
        $peminjaman->update([
            'tanggal_kembali'       => $tanggalKembali,
            'jumlah_hari_terlambat' => $terlambat,
            'status_peminjaman'     => 'selesai',
            'user_pengembali'       => auth()->id(),
        ]);

        // update status rm
        $peminjaman->pasien->update([
            'status_rm' => 'tersedia'
        ]);

        return redirect()->route('admin.peminjaman')->with('success', 'Rekam Medis berhasil dikembalikan');
    }

    public function riwayat()
    {
        $riwayats = Peminjaman::with([
            'pasien',
            'kunjungan.poli',
            'permintaan.user.poli',
            'userPeminjam',
            'userPengembali',
        ])
            ->where('status_peminjaman', 'selesai')
            ->latest('tanggal_kembali')
            ->get();

        return view('admin.riwayatpeminjaman', compact('riwayats'));
    }
}
