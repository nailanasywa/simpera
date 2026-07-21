<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Models\Poli;
use App\Models\Kunjungan;
USE App\Models\Peminjaman;
use App\Http\Requests\KunjunganRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KunjunganController extends Controller
{
    public function index(Request $request) {
        $pasien = null;
        $polis = Poli::orderBy('nama_poli')->get();

        // search pasien
        if ($request->filled('no_rm')){
            $pasien = Pasien::with([
                'kunjungan.poli',
                'kunjungan.creator'
            ])->where('no_rm', $request->no_rm)->first();
        }

        return view('admin.transaksi.kunjungan', [
            'pasien'    => $pasien,
            'polis'     => $polis,
        ]);
    }

    public function storeKunjungan(KunjunganRequest $request){
        // validation
        $pasien = Pasien::findOrFail($request->pasien_id);
        if ($pasien->status_rm == 'dipinjam') {
            return redirect()->route('admin.kunjungan', ['no_rm' => $pasien->no_rm])->with('error', 'Rekam Medis Pasien masih dipinjam.');
        }

        $pernah = Kunjungan::where('pasien_id', $request->pasien_id)->where('poli_id', $request->poli_id)->exists();
        $jenis = $pernah? 'lama' : 'baru';

        DB::transaction(function() use ($request, $pasien, $jenis){
            // simpan kunjungan
            $kunjungan = Kunjungan::create([
                'pasien_id'         => $request->pasien_id,
                'poli_id'           => $request->poli_id,
                'jenis_kunjungan'   => $jenis,
                'kepesertaan'       => $request->kepesertaan,
                'tanggal_kunjungan' => $request->tanggal_kunjungan,
                'created_by'        => auth()->id(),
            ]);

            // simpan peminjaman
            Peminjaman::create([
                'pasien_id'                 => $request->pasien_id,
                'kunjungan_id'              => $kunjungan->id,
                'permintaan_peminjaman_id'  => null,
                'jenis_peminjaman'          => 'kunjungan',
                'tanggal_pinjam'            => now(),
                // jt sementara
                'tanggal_jatuh_tempo'       => Carbon::now()->addDay(),
                'tanggal_kembali'           => null,
                'jumlah_hari_terlambat'     => 0,
                'status_peminjaman'         => 'dipinjam',
            ]);

            // update RM
            $pasien->update([
                'status_rm' => 'dipinjam'
            ]);
        });

        // return redirect()->route('admin.kunjungan')->with('success', 'Data Kunjungan berhasil dibuat');
        return redirect()->route('admin.kunjungan', ['no_rm' => $pasien->no_rm])->with('success', 'Data kunjungan berhasil di tambahkan.');
    }
}
