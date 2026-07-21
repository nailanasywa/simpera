@extends('layouts.app')

@section('content')
    <div class="page-heading">
        <h3>Dashboard Kepala Puskesmas</h3>

        <p class="text-subtitle text-muted">
            Dashboard Monitoring Sistem Informasi Peminjaman dan Pengembalian Rekam Medis (SIMPERA)
        </p>
    </div>

    <div class="page-content">

        {{-- Statistik --}}
        <section class="row">

            {{-- Total RM --}}
            <div class="col-6 col-lg-3">
                <div class="card">
                    <div class="card-body px-4 py-4-5">
                        <div class="row align-items-center">
                            <div class="col-auto pe-2">
                                <div class="stats-icon blue">
                                    <i class="iconly-boldFolder"></i>
                                </div>
                            </div>

                            <div class="col">
                                <h6 class="text-muted mb-1">
                                    Total Rekam Medis
                                </h6>
                                <h5 class="font-extrabold mb-0">
                                    {{ $totalPasien }}
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Total Peminjaman --}}
            <div class="col-6 col-lg-3">
                <div class="card">
                    <div class="card-body px-4 py-4-5">
                        <div class="row align-items-center">
                            <div class="col-auto pe-2">
                                <div class="stats-icon purple">
                                    <i class="iconly-boldDocument"></i>
                                </div>
                            </div>

                            <div class="col">
                                <h6 class="text-muted mb-1">
                                    Total Peminjaman
                                </h6>
                                <h5 class="font-extrabold mb-0">
                                    {{ $totalPeminjaman }}
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Dipinjam --}}
            <div class="col-6 col-lg-3">
                <div class="card">
                    <div class="card-body px-4 py-4-5">
                        <div class="row align-items-center">
                            <div class="col-auto pe-2">
                                <div class="stats-icon red">
                                    <i class="iconly-boldTime-Circle"></i>
                                </div>
                            </div>

                            <div class="col">
                                <h6 class="text-muted mb-1">
                                    Sedang Dipinjam
                                </h6>
                                <h5 class="font-extrabold mb-0">
                                    {{ $dipinjam }}
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Selesai --}}
            <div class="col-6 col-lg-3">
                <div class="card">
                    <div class="card-body px-4 py-4-5">
                        <div class="row align-items-center">
                            <div class="col-auto pe-2">
                                <div class="stats-icon green">
                                    <i class="iconly-boldTick-Square"></i>
                                </div>
                            </div>

                            <div class="col">
                                <h6 class="text-muted mb-1">
                                    Sudah Selesai
                                </h6>
                                <h5 class="font-extrabold mb-0">
                                    {{ $selesai }}
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Ringkasan --}}
        <section class="row">
            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h4>Ringkasan Pengembalian</h4>
                    </div>

                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span>Tepat Waktu</span>
                            <span class="badge bg-light-success">
                                {{ $tepatWaktu }}
                            </span>
                        </div>

                        <div class="d-flex justify-content-between">
                            <span>Terlambat</span>
                            <span class="badge bg-light-danger">
                                {{ $terlambat }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h4>Aktivitas Peminjaman Terbaru</h4>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No RM</th>
                                        <th>Pasien</th>
                                        <th>Poli</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse($peminjamanTerbaru as $item)
                                        <tr>
                                            <td>{{ $item->pasien?->no_rm }}</td>
                                            <td>{{ $item->pasien?->nama_pasien }}</td>
                                            <td>
                                                {{ $item->kunjungan?->poli?->nama_poli ?? ($item->permintaan?->user?->poli?->nama_poli ?? '-') }}
                                            </td>
                                            <td>
                                                @if ($item->status_peminjaman == 'dipinjam')
                                                    <span class="badge bg-light-warning">
                                                        Dipinjam
                                                    </span>
                                                @else
                                                    <span class="badge bg-light-success">
                                                        Selesai
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-5">
                                                <i class="bi bi-folder2-open fs-1 text-secondary"></i>
                                                <br><br>
                                                Belum ada data.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
