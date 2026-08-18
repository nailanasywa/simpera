@extends('layouts.app')

@section('content')
    <div class="page-heading mb-4">
        <h3 class="fw-bold">
            Halo, {{ Auth::user()->name }} 👋
        </h3>

        <p class="text-muted mb-0">
            Selamat datang di <strong>SIMPERA</strong>. Berikut ringkasan aktivitas peminjaman dan pengembalian rekam medis.
        </p>
    </div>

    <div class="page-content">

        {{-- Statistik --}}
        <section class="row g-4">

            {{-- Total RM --}}
            <div class="col-md-6 col-xl-3">
                <div class="card dashboard-card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="dashboard-icon bg-primary-subtle text-primary">
                            <i class="bi bi-folder2-open"></i>
                        </div>

                        <div class="ms-3">
                            <span class="text-muted small">
                                Total Rekam Medis
                            </span>

                            <h2 class="fw-bold mb-1">
                                {{ $totalPasien }}
                            </h2>

                            <small class="text-success">
                                Data aktif
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Dipinjam --}}
            <div class="col-md-6 col-xl-3">
                <div class="card dashboard-card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="dashboard-icon bg-warning-subtle text-warning">
                            <i class="bi bi-journal-medical"></i>
                        </div>

                        <div class="ms-3">
                            <span class="text-muted small">RM Dipinjam</span>
                            <h2 class="fw-bold mb-0">{{ $rmDipinjam }}</h2>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Pending --}}
            <div class="col-md-6 col-xl-3">
                <div class="card dashboard-card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="dashboard-icon bg-danger-subtle text-danger">
                            <i class="bi bi-hourglass-split"></i>
                        </div>

                        <div class="ms-3">
                            <span class="text-muted small">Approval Pending</span>
                            <h2 class="fw-bold mb-0">{{ $approvalPending }}</h2>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Selesai --}}
            <div class="col-md-6 col-xl-3">
                <div class="card dashboard-card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="dashboard-icon bg-success-subtle text-success">
                            <i class="bi bi-patch-check-fill"></i>
                        </div>

                        <div class="ms-3">
                            <span class="text-muted small">Peminjaman Selesai</span>
                            <h2 class="fw-bold mb-0">{{ $totalSelesai }}</h2>
                        </div>
                    </div>
                </div>
            </div>

        </section>

        {{-- Tabel Dashboard --}}
        <section class="row mt-4">

            {{-- Peminjaman Terbaru --}}
            <div class="col-lg-8">

                <div class="card shadow-sm">
                    <div class="card-header bg-white border-0">
                        <div class="d-flex justify-content-between align-items-center">

                            <div>
                                <h5 class="fw-bold mb-1">
                                    Peminjaman Terbaru
                                </h5>
                            </div>

                        </div>
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
                                                    <span class="badge rounded-pill bg-warning text-black">
                                                        <i class="bi bi-hourglass-split me-1"></i>
                                                        Dipinjam
                                                    </span>
                                                @else
                                                    <span class="badge rounded-pill bg-success-subtle text-success">
                                                        <i class="bi bi-check-circle-fill me-1"></i>
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
                            <div class="pending-item p-3 mb-3">

                                <h6 class="fw-semibold mb-1">
                                    {{ $item->pasien?->nama_pasien }}
                                </h6>

                                <small class="text-muted d-block">
                                    {{ $item->user?->poli?->nama_poli }}
                                </small>

                                <small class="text-muted">
                                    {{ \Carbon\Carbon::parse($item->tanggal_permintaan)->format('d M Y H:i') }}
                                </small>

                                <div class="mt-2">
                                    <span class="badge bg-warning-subtle text-warning">
                                        Pending
                                    </span>
                                </div>

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

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1">Rekam Medis Tepat Waktu dan Terlambat</h5>
                    <small class="text-muted">
                        Rekap berdasarkan poli
                    </small>
                </div>
                <form action="{{ route('admin.dashboard') }}" method="GET">
                    <select name="bulan" class="form-select" onchange="this.form.submit()">

                        <option value="all" {{ $bulan == 'all' ? 'selected' : '' }}>
                            Semua Bulan
                        </option>

                        <option value="1" {{ $bulan == '1' ? 'selected' : '' }}>
                            Januari
                        </option>

                        <option value="2" {{ $bulan == '2' ? 'selected' : '' }}>
                            Februari
                        </option>

                        <option value="3" {{ $bulan == '3' ? 'selected' : '' }}>
                            Maret
                        </option>

                        <option value="4" {{ $bulan == '4' ? 'selected' : '' }}>
                            April
                        </option>

                        <option value="5" {{ $bulan == '5' ? 'selected' : '' }}>
                            Mei
                        </option>

                        <option value="6" {{ $bulan == '6' ? 'selected' : '' }}>
                            Juni
                        </option>

                        <option value="7" {{ $bulan == '7' ? 'selected' : '' }}>
                            Juli
                        </option>

                        <option value="8" {{ $bulan == '8' ? 'selected' : '' }}>
                            Agustus
                        </option>

                        <option value="9" {{ $bulan == '9' ? 'selected' : '' }}>
                            September
                        </option>

                        <option value="10" {{ $bulan == '10' ? 'selected' : '' }}>
                            Oktober
                        </option>

                        <option value="11" {{ $bulan == '11' ? 'selected' : '' }}>
                            November
                        </option>

                        <option value="12" {{ $bulan == '12' ? 'selected' : '' }}>
                            Desember
                        </option>

                    </select>
                </form>
            </div>

            <div class="card-body">
                <div id="grafikRekamMedis"></div>
                <div id="grafikKosong" class="text-center py-5" style="display: none;">
                    <p class="text-muted mt-3 mb-0">
                        Tidak ada data rekam medis pada bulan yang dipilih.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/extensions/apexcharts/apexcharts.min.js') }}"></script>
    <script>
        const tepatWaktu = @json($tepatWaktu);
        const terlambat = @json($terlambat);
        const kategoriPoli = @json($polis->pluck('nama_poli'));

        // Cek apakah ada data
        const totalData =
            tepatWaktu.reduce((total, value) => total + Number(value), 0) +
            terlambat.reduce((total, value) => total + Number(value), 0);

        if (totalData === 0) {

            // Tidak ada data
            document.getElementById('grafikRekamMedis').style.display = 'none';
            document.getElementById('grafikKosong').style.display = 'block';

        } else {

            // Ada data, tampilkan grafik
            document.getElementById('grafikRekamMedis').style.display = 'block';
            document.getElementById('grafikKosong').style.display = 'none';

            var options = {
                chart: {
                    type: 'bar',
                    height: 400,
                    toolbar: {
                        show: false
                    }
                },

                series: [{
                        name: 'Tepat Waktu',
                        data: tepatWaktu
                    },
                    {
                        name: 'Terlambat',
                        data: terlambat
                    }
                ],

                xaxis: {
                    categories: kategoriPoli,
                    title: {
                        text: 'Poli'
                    }
                },

                yaxis: {
                    title: {
                        text: 'Jumlah Rekam Medis'
                    },
                    min: 0,
                    labels: {
                        formatter: function(value) {
                            return Math.round(value);
                        }
                    }
                },

                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '45%',
                        borderRadius: 4
                    }
                },

                dataLabels: {
                    enabled: false
                },

                legend: {
                    position: 'top'
                },

                tooltip: {
                    y: {
                        formatter: function(value) {
                            return value + ' rekam medis';
                        }
                    }
                }
            };

            var chart = new ApexCharts(
                document.querySelector("#grafikRekamMedis"),
                options
            );

            chart.render();
        }
    </script>
@endsection
