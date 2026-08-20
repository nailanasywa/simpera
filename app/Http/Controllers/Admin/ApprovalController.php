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
    public function index()
    {
        $permintaans = PermintaanPeminjaman::with([
            'pasien',
            'user.poli'
        ])->where('status_approval', 'pending')->latest()->get();

        return view('admin.transaksi.approval', [
            'permintaans'   => $permintaans
        ]);
    }

    public function approve($id)
    {
        $permintaan = PermintaanPeminjaman::findOrFail($id);

        // Validasi sudah diproses
        if ($permintaan->status_approval != 'pending') {
            return redirect()
                ->route('admin.approval')
                ->with('error', 'Permintaan sudah diproses');
        }

        DB::transaction(function () use ($permintaan) {

            // Update status approval
            $permintaan->update([
                'status_approval'  => 'disetujui',
                'tanggal_approval' => now(),
                'approved_by'      => auth()->id(),
            ]);

            // Insert ke peminjaman aktif
            Peminjaman::create([
                'pasien_id'                => $permintaan->pasien_id,
                'kunjungan_id'             => null,
                'permintaan_peminjaman_id' => $permintaan->id,
                'jenis_peminjaman'         => 'non_kunjungan',
                'tanggal_pinjam'           => now(),
                'tanggal_jatuh_tempo'      => now()->addDay(),
                'status_peminjaman'        => 'dipinjam',

                // User yang memproses peminjaman
                'user_peminjam'            => auth()->id(),
            ]);

            // Update status RM
            $permintaan->pasien->update([
                'status_rm' => 'dipinjam',
            ]);
        });

        return redirect()
            ->route('admin.approval')
            ->with('success', 'Permintaan berhasil disetujui');
    }

    public function reject(Request $request, $id)
    {
        $permintaan = PermintaanPeminjaman::findOrFail($id);

        // Validasi sudah diproses
        if ($permintaan->status_approval != 'pending') {
            return redirect()
                ->route('admin.approval')
                ->with('error', 'Permintaan sudah diproses');
        }

        // Validasi alasan penolakan wajib diisi
        $request->validate([
            'alasan_penolakan' => 'required|string|max:1000',
        ], [
            'alasan_penolakan.required' => 'Alasan penolakan wajib diisi.',
            'alasan_penolakan.max' => 'Alasan penolakan maksimal 1000 karakter.',
        ]);

        $permintaan->update([
            'status_approval'   => 'ditolak',
            'tanggal_approval'  => now(),
            'approved_by'       => auth()->id(),
            'alasan_penolakan'  => $request->alasan_penolakan,
        ]);

        return redirect()
            ->route('admin.approval')
            ->with('success', 'Permintaan berhasil ditolak');
    }
}
