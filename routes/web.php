<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// admin
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PasienController;
use App\Http\Controllers\Admin\KunjunganController;
use App\Http\Controllers\Admin\PeminjamanController;
use App\Http\Controllers\Admin\ApprovalController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\NotifikasiController;
use App\Http\Controllers\Admin\PermintaanPeminjaman;
use App\Http\Controllers\Admin\PermintaanPeminjamanController;
// kepala puskesmas
use App\Http\Controllers\Kepala\DashboardController as KepalaDashboardController;

// petugas
use App\Http\Controllers\Petugas\DashboardController as PetugasDashboardController;
use App\Http\Controllers\Petugas\PermintaanController;

Route::redirect('/', '/login');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:superadmin'])->prefix('admin')->name('admin.')->group(function () {
    //peminjaman
    Route::get('/riwayat-peminjaman', [PeminjamanController::class, 'riwayat'])->name('riwayat.peminjaman');

    //permintaan peminjaman
    Route::get('/permintaan', [PermintaanPeminjamanController::class, 'index'])
        ->name('permintaan');

    Route::get('/permintaan/create', [PermintaanPeminjamanController::class, 'createPermintaan'])
        ->name('permintaan.create');

    Route::post('/permintaan', [PermintaanPeminjamanController::class, 'storePermintaan'])
        ->name('permintaan.store');

    // notifikasi
    Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi');
    Route::put('/notifikasi/{id}', [NotifikasiController::class, 'update'])->name('notifikasi.update');
});

// admin
Route::middleware(['auth', 'role:admin,superadmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Master (user)
    Route::get('/users', [UserController::class, 'index'])->name('user');

    // poli
    Route::post('/poli/store', [UserController::class, 'storePoli'])->name('poli.store');
    Route::put('/poli/{poli}/update', [UserController::class, 'updatePoli'])->name('poli.update');
    Route::delete('/poli/{poli}/delete', [UserController::class, 'destroyPoli'])->name('poli.destroy');

    // user
    Route::get('/users/create', [UserController::class, 'createUser'])->name('user.create');
    Route::post('/users/store', [UserController::class, 'storeUser'])->name('user.store');
    Route::get('/users/{user}/edit', [UserController::class, 'editUser'])->name('user.edit');
    Route::put('/users/{user}/update', [UserController::class, 'updateUser'])->name('user.update');
    Route::delete('/users/{user}/delete', [UserController::class, 'destroyUser'])->name('user.delete');

    // pasien (data rekam medis)
    Route::get('/pasien', [PasienController::class, 'index'])->name('pasien');
    Route::get('/pasien/create', [PasienController::class, 'createPasien'])->name('pasien.create');
    Route::post('/pasien/store', [PasienController::class, 'storePasien'])->name('pasien.store');
    Route::get('pasien/{pasien}/edit', [PasienController::class, 'editPasien'])->name('pasien.edit');
    Route::put('pasien/{pasien}/update', [PasienController::class, 'updatePasien'])->name('pasien.update');
    Route::delete('pasien/{pasien}/delete', [PasienController::class, 'destroyPasien'])->name('pasien.destroy');

    Route::post('/pasien/import', [PasienController::class, 'import'])->name('pasien.import');
    Route::get('/pasien/template', [PasienController::class, 'downloadTemplate'])->name('pasien.template');

    // transaksi
    // kunjungan
    Route::get('/kunjungan', [KunjunganController::class, 'index'])->name('kunjungan');
    Route::post('/kunjungan/store', [KunjunganController::class, 'storeKunjungan'])->name('kunjungan.store');

    // approval permintaan peminjaman
    Route::get('/approval', [ApprovalController::class, 'index'])->name('approval');
    Route::put('/approval/{permintaan}/approve', [ApprovalController::class, 'approve'])->name('approval.approve');
    Route::put('/approval/{permintaan}/reject', [ApprovalController::class, 'reject'])->name('approval.reject');

    // peminjaman aktif
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman');
    Route::put('/peminjaman/{peminjaman}/selesai', [PeminjamanController::class, 'pinjamSelesai'])->name('peminjaman.selesai');

    // laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
    Route::get('/laporan/export', [LaporanController::class, 'export'])->name('laporan.export');
    Route::get('/laporan/peminjaman/pdf', [LaporanController::class, 'exportPdf'])->name('laporan.pdf');
});

// kepala puskesmas
Route::middleware(['auth', 'role:kepala_puskesmas'])->prefix('kepala')->name('kepala.')->group(function () {
    // Route::get('/dashboard', [KepalaDashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
    Route::get('/laporan/export', [LaporanController::class, 'export'])->name('laporan.export');
});

// petugas
Route::middleware(['auth', 'role:petugas_poli'])->prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/dashboard', [PetugasDashboardController::class, 'index'])->name('dashboard');
    Route::get('/permintaan', [PermintaanController::class, 'index'])->name('permintaan');
    Route::get('/permintaan/create', [PermintaanController::class, 'createPermintaan'])->name('permintaan.create');
    Route::post('/permintaan/store', [PermintaanController::class, 'storePermintaan'])->name('permintaan.store');
});
require __DIR__ . '/auth.php';
