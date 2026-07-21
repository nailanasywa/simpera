@extends('layouts.app')

@section('content')
    <div class="page-heading">
        <h3>Dashboard Admin</h3>
        <p class="text-subtitle text-muted">
            Selamat datang di Sistem Informasi Peminjaman dan Pengembalian Rekam Medis (SIMPERA)
        </p>
    </div>

    <div class="page-content">

        {{-- Statistik --}}
        <section class="row">

            {{-- Total RM --}}
            <div class="col-6 col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body px-4 py-4-5">
                        <div class="row align-items-center">
                            <div class="col-auto pe-2">
                                <div class="stats-icon blue mb-0">
                                    <i class="iconly-boldFolder"></i>
                                </div>
                            </div>
                            <div class="col">
                                <h6 class="text-muted font-semibold mb-1">
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

            {{-- Dipinjam --}}
            <div class="col-6 col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body px-4 py-4-5">
                        <div class="row align-items-center">
                            <div class="col-auto pe-2">
                                <div class="stats-icon purple mb-2">
                                    <i class="iconly-boldDocument"></i>
                                </div>
                            </div>
                            <div class="col">
                                <h6 class="text-muted font-semibold mb-1">
                                    RM Dipinjam
                                </h6>
                                <h5 class="font-extrabold mb-0">
                                    {{ $rmDipinjam }}
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Pending --}}
            <div class="col-6 col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body px-4 py-4-5">
                        <div class="row align-items-center">
                            <div class="col-auto pe-2">
                                <div class="stats-icon red mb-2">
                                    <i class="iconly-boldTime-Circle"></i>
                                </div>
                            </div>
                            <div class="col">
                                <h6 class="text-muted font-semibold mb-1">
                                    Approval Pending
                                </h6>
                                <h5 class="font-extrabold mb-0">
                                    {{ $approvalPending }}
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Selesai --}}
            <div class="col-6 col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body px-4 py-4-5">
                        <div class="row align-items-center">
                            <div class="col-auto pe-2">
                                <div class="stats-icon green mb-2">
                                    <i class="iconly-boldTick-Square"></i>
                                </div>
                            </div>
                            <div class="col">
                                <h6 class="text-muted font-semibold mb-1">
                                    Peminjaman Selesai
                                </h6>
                                <h5 class="font-extrabold mb-0">
                                    {{ $totalSelesai }}
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>

        {{-- Tabel Dashboard --}}
        <section class="row">

            {{-- Peminjaman Terbaru --}}
            <div class="col-lg-8">

                <div class="card shadow-sm">
                    <div class="card-header">
                        <h4>Peminjaman Terbaru</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No RM</th>
                                        <th>Nama Pasien</th>
                                        <th>Poli</th>
                                        <th>Jenis</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($peminjamanTerbaru as $item)
                                        <tr>
                                            <td>{{ $item->pasien?->no_rm }}</td>
                                            <td>{{ $item->pasien?->nama_pasien }}</td>
                                            <td>
                                                {{ $item->kunjungan?->poli?->nama_poli ?? ($item->permintaan?->user?->poli?->nama_poli ?? '-') }}
                                            </td>
                                            <td>
                                                {{ ucfirst(str_replace('_', ' ', $item->jenis_peminjaman)) }}
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
                                            <td colspan="5" class="text-center py-4">
                                                <i class="bi bi-folder2-open fs-2 text-secondary"></i>
                                                <br><br>
                                                Belum ada data peminjaman.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Approval Pending --}}
            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h4>Approval Pending</h4>
                    </div>

                    <div class="card-body">
                        @forelse($approvalTerbaru as $item)
                            <div class="border rounded p-3 mb-3">
                                <h6 class="mb-1">
                                    {{ $item->pasien?->nama_pasien }}
                                </h6>

                                <small class="text-muted d-block">
                                    {{ $item->user?->poli?->nama_poli }}
                                </small>

                                <small class="text-muted d-block mb-2">
                                    {{ \Carbon\Carbon::parse($item->tanggal_permintaan)->format('d-m-Y H:i') }}
                                </small>

                                <span class="badge bg-light-warning">
                                    Pending
                                </span>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <i class="bi bi-check-circle fs-1 text-success"></i>
                                <br><br>
                                Tidak ada approval yang menunggu.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
