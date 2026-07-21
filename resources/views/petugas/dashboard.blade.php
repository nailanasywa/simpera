@extends('layouts.app')

@section('content')
    <div class="page-heading">
        <h3>Dashboard Petugas Poli</h3>

        <p class="text-subtitle text-muted">
            Selamat datang di Sistem Informasi Peminjaman dan Pengembalian Rekam Medis (SIMPERA)
        </p>
    </div>

    <div class="page-content">
        {{-- Statistik --}}
        <section class="row">
            {{-- Total Permintaan --}}
            <div class="col-12 col-md-4">
                <div class="card">
                    <div class="card-body px-4 py-4-5">
                        <div class="row align-items-center">
                            <div class="col-auto pe-2">
                                <div class="stats-icon blue mb-0">
                                    <i class="iconly-boldDocument"></i>
                                </div>
                            </div>

                            <div class="col">
                                <h6 class="text-muted font-semibold mb-1">
                                    Total Permintaan
                                </h6>
                                <h5 class="font-extrabold mb-0">
                                    {{ $totalPermintaan }}
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Pending --}}
            <div class="col-12 col-md-4">
                <div class="card">
                    <div class="card-body px-4 py-4-5">
                        <div class="row align-items-center">
                            <div class="col-auto pe-2">
                                <div class="stats-icon red mb-0">
                                    <i class="iconly-boldTime-Circle"></i>
                                </div>
                            </div>

                            <div class="col">
                                <h6 class="text-muted font-semibold mb-1">
                                    Menunggu Approval
                                </h6>
                                <h5 class="font-extrabold mb-0">
                                    {{ $pending }}
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Disetujui --}}
            <div class="col-12 col-md-4">
                <div class="card">
                    <div class="card-body px-4 py-4-5">
                        <div class="row align-items-center">
                            <div class="col-auto pe-2">
                                <div class="stats-icon green mb-0">
                                    <i class="iconly-boldTick-Square"></i>
                                </div>
                            </div>

                            <div class="col">
                                <h6 class="text-muted font-semibold mb-1">
                                    Permintaan Disetujui
                                </h6>
                                <h5 class="font-extrabold mb-0">
                                    {{ $disetujui }}
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Riwayat --}}
        <section class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h4>Permintaan Terbaru</h4>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No RM</th>
                                        <th>Nama Pasien</th>
                                        <th>Keperluan</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @forelse($permintaanTerbaru as $item)
                                        <tr>
                                            <td>
                                                {{ $item->pasien?->no_rm }}
                                            </td>

                                            <td>
                                                {{ $item->pasien?->nama_pasien }}
                                            </td>

                                            <td>
                                                {{ $item->keperluan }}
                                            </td>

                                            <td>
                                                {{ \Carbon\Carbon::parse($item->tanggal_permintaan)->format('d-m-Y H:i') }}
                                            </td>

                                            <td>
                                                @if ($item->status_approval == 'pending')
                                                    <span class="badge bg-light-warning">
                                                        Pending
                                                    </span>
                                                @elseif($item->status_approval == 'disetujui')
                                                    <span class="badge bg-light-success">
                                                        Disetujui
                                                    </span>
                                                @else
                                                    <span class="badge bg-light-danger">
                                                        Ditolak
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5">
                                                <i class="bi bi-folder2-open fs-1 text-secondary"></i>
                                                <br><br>
                                                Belum ada permintaan peminjaman.
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
