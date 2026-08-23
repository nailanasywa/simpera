<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermintaanRequest;
use App\Models\Pasien;
use App\Models\User;
use App\Models\PermintaanPeminjaman;
use Illuminate\Http\Request;

class PermintaanPeminjamanController extends Controller
{
    public function index()
    {
        $permintaans = PermintaanPeminjaman::with([
            'pasien',
            'user.poli'
        ])
            ->latest()
            ->get();

        return view('admin.permintaanpeminjaman.index', [
            'permintaans' => $permintaans
        ]);
    }

    public function createPermintaan(Request $request)
    {
        $pasien = null;

        if ($request->filled('no_rm')) {
            $pasien = Pasien::where(
                'no_rm',
                $request->no_rm
            )->first();
        }

        $petugasPoli = User::with('poli')
            ->where('role', 'petugas_poli')
            ->whereNotNull('poli_id')
            ->get();

        return view('admin.permintaanpeminjaman.create', [
            'pasien'      => $pasien,
            'petugasPoli' => $petugasPoli,
        ]);
    }

    public function storePermintaan(PermintaanRequest $request)
    {
        $pasien = Pasien::findOrFail($request->pasien_id);

        if ($pasien->status_rm == 'dipinjam') {
            return redirect()
                ->route('admin.permintaan.create', [
                    'no_rm' => $pasien->no_rm
                ])
                ->with('error', 'Rekam Medis pasien masih dipinjam.');
        }

        PermintaanPeminjaman::create([
            'pasien_id'          => $request->pasien_id,
            'user_id'            => $request->user_id,
            'keperluan'          => $request->keperluan,
            'tanggal_permintaan' => $request->tanggal_permintaan,
            'status_approval'    => 'pending',
        ]);

        return redirect()
            ->route('admin.permintaan')
            ->with('success', 'Permintaan berhasil dikirim.');
    }
}
