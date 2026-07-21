<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Pasien;
use App\Http\Requests\PasienRequest;

class PasienController extends Controller
{
    public function index() {
        $pasiens = Pasien::latest()->get();

        return view('admin.master.pasien', [
            'pasiens' => $pasiens,
        ]);
    }

    public function createPasien() {
        return view('admin.master.formpasien');
    }

    public function storePasien(PasienRequest $request){
        $lastPasien = Pasien::latest()->first();

        if ($lastPasien) {
            $nomor = (int) $lastPasien->no_rm + 1;
        }else {
            $nomor = 1;
        }

        $no_rm = str_pad($nomor, 8, '0', STR_PAD_LEFT);

        Pasien::create([
            'no_rm'         => $no_rm,
            'nama_pasien'   => $request->nama_pasien,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'umur'          => Carbon::parse($request->tanggal_lahir)->age,
            'nama_kk'       => $request->nama_kk,
            'alamat'        => $request->alamat,
            'status_rm'     => 'tersedia',
        ]);

        return redirect()->route('admin.pasien')->with('success', 'Data pasien berhasil ditambahkan');
    }

    public function editPasien(Pasien $pasien) {
        return view('admin.master.formpasien', [
            'pasien'    => $pasien,
        ]);
    }

    public function updatePasien(Pasienrequest $request, Pasien $pasien) {
        $pasien->update([
            'nama_pasien'       => $request->nama_pasien,
            'jenis_kelamin'     => $request->jenis_kelamin,
            'tanggal_lahir'     => $request->tanggal_lahir,
            'umur'              => Carbon::parse($request->tanggal_lahir)->age,
            'nama_kk'           => $request->nama_kk,
            'alamat'            => $request->alamat,
        ]);

        return redirect()->route('admin.pasien')->with('success', 'Data pasien berhasil diperbarui');
    }

    public function destroyPasien(Pasien $pasien) {
        if (
            $pasien->kunjungan()->exists() || $pasien->peminjaman()->exists()
        ) {
            return redirect()->route('admin.pasien')->with('error', 'Data pasien tidak dapat dihapus karena sudah memiliki riwayat pelayanan.');
        }
        
        $pasien->delete();

        return redirect()->route('admin.pasien')->with('success', 'Data pasien berhasil dihapus');
    }
}
