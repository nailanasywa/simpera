<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    public function index()
    {
        $notifikasis = Notifikasi::orderBy('id')->get();

        return view('admin.notifikasi', compact('notifikasis'));
    }

    public function update(Request $request, $id)
    {
        $notifikasi = Notifikasi::findOrFail($id);

        $request->validate([
            'waktu' => 'required|date_format:H:i',
            'status' => 'required|boolean',
        ], [
            'waktu.required' => 'Waktu notifikasi wajib diisi.',
            'waktu.date_format' => 'Format waktu tidak valid.',
        ]);

        $notifikasi->update([
            'waktu' => $request->waktu,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.notifikasi')
            ->with('success', 'Pengaturan notifikasi berhasil diperbarui.');
    }
}
