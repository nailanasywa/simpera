<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRequest;
use App\Http\Requests\PoliRequest;
use App\Models\Poli;
use App\Models\User;

class UserController extends Controller
{
    public function index() {
        $polis = Poli::latest()->get();
        // $users = User::latest()->get();
        $users = User::with('poli')->latest()->get();

        return view('admin.master.user', [
            'polis' => $polis,
            'users' => $users
        ]);
    }

    public function storePoli(PoliRequest $request) {
        Poli::create([
            'nama_poli' => $request->nama_poli
        ]);

        return redirect()->route('admin.user')->with('success', 'Data poli berhasil ditambah');
    }

    public function updatePoli(PoliRequest $request, Poli $poli) {
        $poli->update([
            'nama_poli' => $request->nama_poli
        ]);

        return redirect()->route('admin.user')->with('success', 'Data Poli berhasil di perbarui');
    }

    public function destroyPoli(Poli $poli) {
        $poli->delete();

        return redirect()->route('admin.user')->with('success', 'Data Poli berhasil di hapus');
    }

    public function createUser() {
        $polis = Poli::orderBy('nama_poli')->get();

        return view('admin.master.formuser', [
            'polis' => $polis,
        ]);
    }

    public function storeUser(UserRequest $request) {
        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'role'      => $request->role,
            'poli_id'   => $request->role == 'petugas_poli' ? $request->poli_id : null,
            'no_hp'     => $request->no_hp,
            'password'  => Hash::make($request->password),
        ]);

        return redirect()->route('admin.user')->with('success', 'Data user berhasil ditambahkan');
    }

    public function editUser(User $user) {
        $polis = Poli::orderBy('nama_poli')->get();

        return view('admin.master.formuser', [
            'user'  => $user,
            'polis' => $polis,
        ]);
    }

    public function updateUser(UserRequest $request, User $user) {
        $user->update([
            'name'      => $request->name,
            'email'     => $request->email,
            'role'      => $request->role,
            'poli_id'   => $request->role == 'petugas_poli' ? $request->poli_id : null,
            'no_hp'     => $request->no_hp,
        ]);

        if ($request->filled('password')) {
            $user->update([
                'password'  => Hash::make($request->password)
            ]);
        }

        return redirect()->route('admin.user')->with('success', 'Data User berhasil di perbarui');
    }

    public function destroyUser(User $user) {
        if (in_array($user->role, [
            'admin', 'kepala_puskesmas'
        ])) {
            return back()->with('error', 'User tersebut tidak dapat dihapus.');
        }

        $user->delete();

        return redirect()->route('admin.user')->with('success', 'Data user berhasil dihapus');
    }
}
