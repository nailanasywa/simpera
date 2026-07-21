@extends('layouts.app')

@section('content')
    <div class="page-heading">
        <h3>Laporan Peminjaman Rekam Medis</h3>
        <p class="text-subtitle text-muted">
            Halaman Laporan Peminjaman Rekam Medis
        </p>
    </div>

    <div class="page-content">
        {{-- card filter --}}
        <div class="card shadow-sm">
            <div class="card-header">
                <h4>Filter Laporan</h4>
            </div>
            <div class="card-body">
                <form action="{{ route($routePrefix . '.laporan') }}" method="get">
                    {{-- rentang waktu --}}
                    <div class="mb-4">
                        <h5 class="mb-3">Rentang Waktu</h5>
                        <div class="row align-items-end">
                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="filter" value="hari_ini" {{ request('filter') == 'hari_ini' ? 'checked' : '' }}>
                                    <label class="form-check-label">Hari ini</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="filter" value="7_hari" {{ request('filter') == '7_hari' ? 'checked' : '' }}>
                                    <label class="form-check-label">7 Hari Terakhir</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="filter" value="bulan" {{ request('filter') == 'bulan' ? 'checked' : '' }}>
                                    <label class="form-check-label">Pilih Bulan</label>
                                </div>
                                <select name="bulan" class="form-select mt-2">
                                    <option value="">Pilih Bulan</option>
                                    @foreach ([
                                        1=>'Januari',
                                        2=>'Februari',
                                        3=>'Maret',
                                        4=>'April',
                                        5=>'Mei',
                                        6=>'Juni',
                                        7=>'Juli',
                                        8=>'Agustus',
                                        9=>'September',
                                        10=>'Oktober',
                                        11=>'November',
                                        12=>'Desember',
                                    ] as $key=>$bulan)
                                        <option value="{{ $key }}" {{ request('bulan') == $key ? 'selected' : '' }}>{{ $bulan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="filter" value="tanggal" {{ request('filter') == 'tanggal' ? 'checked' : '' }}>
                                    <label class="form-check-label">Pilih Tanggal</label>
                                </div>
                                <div class="d-flex mt-2">
                                    <input type="date" class="form-control" name="tanggal_awal" value="{{ request('tanggal_awal') }}">
                                    <span class="mx-2 mt-2">s/d</span>
                                    <input type="date" class="form-control" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>
                    {{-- Filter --}}
                    <div class="row align-items-end">
                        <div class="col-md-3">
                            <select name="jenis_peminjaman" class="form-select">
                                <option value="">Jenis Peminjaman</option>
                                <option value="kunjungan" {{ request('jenis_peminjaman') == 'kunjungan' ? 'selected' : '' }}>Kunjungan</option>
                                <option value="non_kunjungan" {{ request('jenis_peminjaman') == 'non_kunjungan' ? 'selected' : '' }}>Non Kunjungan</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="poli_id" class="form-select">
                                <option value="">Semua Poli</option>
                                @foreach ($polis as $poli)
                                    <option value="{{ $poli->id }}" {{ request('poli_id') == $poli->id ? 'selected' : '' }}>
                                        {{ $poli->nama_poli }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 text-end">
                            <button class="btn btn-primary">Terapkan</button>
                            <a href="{{ route($routePrefix . '.laporan') }}" class="btn btn-light-secondary">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- card tabel rekap --}}
        <div class="card shadow-sm mt-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Laporan</h4>
                <a href="{{ route($routePrefix . '.laporan.export', request()->query()) }}" class="btn btn-outline-success btn-sm">
                    <i class="bi bi-file-earmark-excel"></i>
                    Export Excel
                </a>
            </div>
            <div class="card-body">
                {{-- card total per poli --}}
                <div class="row">
                    @foreach ($rekapPoli as $item)
                        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                            <div class="border rounded text-center p-3 h-100">
                                <h5 class="mb-2">{{ $item['nama'] }}</h5>
                                <h2 class="text-primary">{{ $item['jumlah'] }}</h2>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-2">
                    <strong>Total = {{ $total }} Peminjaman</strong>
                </div>

                {{-- tabel laporan --}}
                <div class="table-responsive mt-4">
                    <table class="table table-hover align-middle" id="tableLaporan">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No. RM</th>
                                <th>Nama</th>
                                <th>Poli</th>
                                <th>Jenis Peminjaman</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Kembali</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($laporans as $laporan)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $laporan->pasien->no_rm }}</td>
                                    <td>{{ $laporan->pasien->nama_pasien }}</td>
                                    <td>
                                        @if ($laporan->jenis_peminjaman == 'kunjungan')
                                            {{ $laporan->kunjungan?->poli?->nama_poli }}
                                        @else
                                            {{ $laporan->permintaan?->user?->poli?->nama_poli }}
                                        @endif
                                    </td>
                                    <td>{{ ucfirst(str_replace('_','', $laporan->jenis_peminjaman)) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($laporan->tanggal_pinjam)->format('d-m-Y H:i') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($laporan->tanggal_kembali)->format('d-m-Y H:i') }}</td>
                                    <td>
                                        @if ($laporan->jumlah_hari_terlambat > 0)
                                            <span class="badge bg-light-danger">Terlambat</span>
                                        @else
                                            <span class="badge bg-light-success">Tepat Waktu</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        {{-- jquery datatables --}}
        <script>
            initDataTable('#tableLaporan');
        </script>
    @endpush
@endsection
