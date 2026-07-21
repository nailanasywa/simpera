<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Models\PermintaanPeminjaman;
use App\Http\Requests\PermintaanRequest;
use Illuminate\Http\Request;

class PermintaanController extends Controller
{
    public function index() {
        $permintaans = PermintaanPeminjaman::with('pasien')
                        ->where('user_id', auth()->id())
                        ->latest()->get();

        return view('petugas.permintaan', [
            'permintaans'   => $permintaans,
        ]);
    }

    public function createPermintaan(Request $request) {
        $pasien = null;

        if ($request->filled('no_rm')) {
            $pasien = Pasien::where(
                'no_rm',
                $request->no_rm
            )->first();
        }

        return view('petugas.createpermintaan', [
            'pasien'    => $pasien,
        ]);
    }

    public function storePermintaan(PermintaanRequest $request) {
        // ux information
        $pasien = Pasien::findOrFail($request->pasien_id);
        if ($pasien->status_rm == 'dipinjem') {
            return redirect()->route('petugas.permintaan.create', [
                'no_rm' => $pasien->no_rm
            ])->with('error', 'Rekam Medis pasien masih dipinjam.');
        }
        
        PermintaanPeminjaman::create([
            'pasien_id'             => $request->pasien_id,
            'user_id'               => auth()->id(),
            'keperluan'             => $request->keperluan,
            'tanggal_permintaan'    => $request->tanggal_permintaan,
            'status_approval'       => 'pending',
        ]);

        return redirect()->route('petugas.permintaan')->with('success', 'Permintaan berhasil dikirim');
    }
}
