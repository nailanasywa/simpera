@extends('layouts.app')

@section('title', 'Riwayat Peminjaman')

@section('content')

    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Riwayat Peminjaman</h3>
                    <p class="text-subtitle text-muted">
                        Riwayat peminjaman dan pengembalian rekam medis
                    </p>
                </div>

                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">
                                    Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                Riwayat Peminjaman
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">

            <div class="card">

                <div class="card-header">
                    <h4 class="card-title">
                        Data Riwayat Peminjaman dan Pengembalian
                    </h4>
                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-hover" id="tableRiwayat">

                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No. RM</th>
                                    <th>Nama Pasien</th>
                                    <th>Poli</th>
                                    <th>Jenis Peminjaman</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Status</th>
                                    <th>Petugas Peminjam</th>
                                    <th>Petugas Pengembali</th>
                                </tr>
                            </thead>

                            <tbody>

                                @forelse ($riwayats as $riwayat)
                                    <tr>

                                        <td>
                                            {{ $loop->iteration }}
                                        </td>

                                        <td>
                                            {{ $riwayat->pasien?->no_rm ?? '-' }}
                                        </td>

                                        <td>
                                            {{ $riwayat->pasien?->nama_pasien ?? '-' }}
                                        </td>

                                        <td>
                                            @if ($riwayat->kunjungan)
                                                {{ $riwayat->kunjungan->poli?->nama_poli ?? '-' }}
                                            @elseif ($riwayat->permintaan)
                                                {{ $riwayat->permintaan->user?->poli?->nama_poli ?? '-' }}
                                            @else
                                                -
                                            @endif
                                        </td>

                                        <td>
                                            @if ($riwayat->jenis_peminjaman === 'kunjungan')
                                                <span class="badge bg-primary">
                                                    Kunjungan
                                                </span>
                                            @else
                                                <span class="badge bg-info">
                                                    Non-Kunjungan
                                                </span>
                                            @endif
                                        </td>

                                        <td>
                                            {{ $riwayat->tanggal_pinjam ? \Carbon\Carbon::parse($riwayat->tanggal_pinjam)->format('d-m-Y H:i') : '-' }}
                                        </td>

                                        <td>
                                            {{ $riwayat->tanggal_kembali ? \Carbon\Carbon::parse($riwayat->tanggal_kembali)->format('d-m-Y H:i') : '-' }}
                                        </td>

                                        <td>
                                            @if (\Carbon\Carbon::parse($riwayat->tanggal_kembali)->gt(\Carbon\Carbon::parse($riwayat->tanggal_jatuh_tempo)))
                                                <span class="badge bg-danger">
                                                    Terlambat
                                                </span>
                                            @else
                                                <span class="badge bg-success">
                                                    Tepat Waktu
                                                </span>
                                            @endif
                                        </td>
                                        </td>

                                        <td>
                                            {{ $riwayat->userPeminjam?->name ?? '-' }}
                                        </td>

                                        <td>
                                            {{ $riwayat->userPengembali?->name ?? '-' }}
                                        </td>

                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="10" class="text-center py-4">
                                            <span class="text-muted">
                                                Belum ada riwayat peminjaman.
                                            </span>
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </section>

    </div>
    @push('scripts')
        {{-- jquery datatables --}}
        <script>
            initDataTable('#tableRiwayat');
        </script>
    @endpush
@endsection
