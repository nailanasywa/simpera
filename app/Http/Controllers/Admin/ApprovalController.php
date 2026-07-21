<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\PermintaanPeminjaman;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    public function index() {
        $permintaans = PermintaanPeminjaman::with([
            'pasien',
            'user.poli'
        ])->where('status_approval', 'pending')->latest()->get();

        return view('admin.transaksi.approval', [
            'permintaans'   => $permintaans
        ]);
    }

    public function approve($id) {
        $permintaan = PermintaanPeminjaman::findOrFail($id);

        // validasi sudah di proses
        if ($permintaan->status_approval != 'pending') {
            return redirect()->route('admin.approval')->with('error', 'Permintaan sudah diproses');
        }

        DB::transaction(function () use ($permintaan) {

            // update status approval
            $permintaan->update([
                'status_approval'   => 'disetujui',
                'tanggal_approval'  => now(),
                'approved_by'       => auth()->id(),
            ]);

            // insert ke peminjaman aktif
            Peminjaman::create([
                'pasien_id'                 => $permintaan->pasien_id,
                'kunjungan_id'              => null,
                'permintaan_peminjaman_id'  => $permintaan->id,
                'jenis_peminjaman'          => 'non_kunjungan',
                'tanggal_pinjam'            => now(),
                'tanggal_jatuh_tempo'       => now()->addDay(),
                'status_peminjaman'         => 'dipinjam',
            ]);

            // update status rm
            $permintaan->pasien->update([
                'status_rm' => 'dipinjam',
            ]);
        });

        return redirect()->route('admin.approval')->with('success', 'Permintaan berhail disetujui');
    }

    public function reject($id) {
        $permintaan = PermintaanPeminjaman::findOrFail($id);

        if ($permintaan->status_approval != 'pending') {
            return redirect()->route('admin.approval')->with('error', 'Permintaan sudah diproses');
        }

        $permintaan->update([
            'status_approval'   => 'ditolak',
            'tanggal_approval'  => now(),
            'approved_by'       => auth()->id(),
        ]);

        return redirect()->route('admin.approval')->with('success', 'Permintaan berhasil ditolak');
    }
}
