@extends('layouts.app')

@section('content')

    <div class="page-heading">
        <h3>Kelola Data Peminjaman Rekam Medis</h3>
        <p class="text-subtitle text-muted">
            Halaman Kelola Data Peminjaman Data Rekam Medis
        </p>
    </div>

    <div class="page-content">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>List Peminjaman Data Rekam Medis</h4>
                <span class="badge {{ $totalData > 0 ? 'bg-light-primary' : 'bg-light-dark' }}">Total Data :
                    {{ $totalData }}</span>
            </div>

            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-8">
                        {{-- filter --}}
                        <form action="{{ route('admin.peminjaman') }}" method="GET">
                            <div class="row mb-4">
                                {{-- Label --}}
                                <div class="col-md-2">
                                    <label class="fw-bold mt-2">Filter By :</label>
                                </div>
                                {{-- Isi Filter --}}
                                <div class="col-md-10">
                                    <div class="row g-2">
                                        {{-- Poli --}}
                                        <div class="col-md-3">
                                            <select name="poli_id" class="form-select">
                                                <option value="">Semua Poli</option>
                                                @foreach ($polis as $poli)
                                                    <option value="{{ $poli->id }}"
                                                        {{ request('poli_id') == $poli->id ? 'selected' : '' }}>
                                                        {{ $poli->nama_poli }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        {{-- Jenis --}}
                                        <div class="col-md-3">
                                            <select name="jenis_peminjaman" class="form-select">
                                                <option value="">Semua Jenis</option>
                                                <option value="kunjungan"
                                                    {{ request('jenis_peminjaman') == 'kunjungan' ? 'selected' : '' }}>
                                                    Kunjungan
                                                </option>
                                                <option value="non_kunjungan"
                                                    {{ request('jenis_peminjaman') == 'non_kunjungan' ? 'selected' : '' }}>
                                                    Non Kunjungan
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mt-2 g-2">
                                        {{-- Awal --}}
                                        <div class="col-md-3">
                                            <input type="date" name="tanggal_awal" class="form-control"
                                                value="{{ request('tanggal_awal') }}">
                                        </div>
                                        <div class="col-auto d-flex align-items-center">s/d</div>
                                        {{-- Akhir --}}
                                        <div class="col-md-3">
                                            <input type="date" name="tanggal_akhir" class="form-control"
                                                value="{{ request('tanggal_akhir') }}">
                                        </div>
                                        {{-- button --}}
                                        <div class="col-auto">
                                            <button class="btn btn-primary">
                                                <i class="bi bi-funnel"></i>
                                                Filter
                                            </button>
                                            <a href="{{ route('admin.peminjaman') }}" class="btn btn-light-secondary">
                                                <i class="bi bi-arrow-clockwise"></i>
                                                Reset
                                            </a>
                                        </div>
                                    </div>
                                    {{-- hari ini --}}
                                    <div class="row">
                                        {{-- Hari Ini --}}
                                        <div class="col-md-2 d-flex align-items-center">
                                            <div class="form-check form-check-sm">
                                                <input class="form-check-input form-check-primary form-check-glow" type="checkbox" id="hariIni"
                                                    name="hari_ini" value="1"
                                                    {{ request('hari_ini') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="hariIni">Hari Ini</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        {{-- end filter --}}
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="tablePeminjaman">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No. RM</th>
                                <th>Nama</th>
                                <th>Poli</th>
                                <th>Jenis Pinjam</th>
                                <th>Tanggal Pinjam</th>
                                <th>Jatuh Tempo</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($peminjamans as $peminjaman)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $peminjaman->pasien->no_rm }}</td>
                                    <td>{{ $peminjaman->pasien->nama_pasien }}</td>
                                    <td>
                                        @if ($peminjaman->jenis_peminjaman == 'kunjungan')
                                            {{ $peminjaman->kunjungan?->poli?->nama_poli }}
                                        @else
                                            {{ $peminjaman->permintaan?->user?->poli?->nama_poli }}
                                        @endif
                                    </td>
                                    <td>{{ ucfirst(str_replace('_', '-', $peminjaman->jenis_peminjaman)) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d-m-Y H:i') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_jatuh_tempo)->format('d-m-Y H:i') }}
                                    </td>
                                    <td>
                                        @if ($peminjaman->status_peminjaman == 'selesai')
                                            <span class="badge bg-light-success">Selesai</span>
                                        @elseif (now()->gt($peminjaman->tanggal_jatuh_tempo))
                                            <span class="badge bg-light-danger">Terlambat</span>
                                        @else
                                            <span class="badge bg-light-warning">Dipinjam</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-outline-success btn-sm btn-selesai"
                                            data-id="{{ $peminjaman->id }}"
                                            data-nama="{{ $peminjaman->pasien->nama_pasien }}">Selesai</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- form hidden --}}
                    <form id="formSelesai" method="post" style="display:none">
                        @csrf
                        @method('PUT')
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.querySelectorAll('.btn-selesai').forEach(button => {
                button.addEventListener('click', function() {
                    let id = this.dataset.id;
                    let nama = this.dataset.nama;

                    Swal.fire({
                        title: 'Selesaikan Peminjaman ?',
                        text: 'Rekam medis pasien "' + nama + '" sudah dikembalikan ?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Ya',
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#435ebe',
                        cancelButtonColor: '#dc3545',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let form = document.getElementById('formSelesai');
                            form.action = "/admin/peminjaman/" + id + "/selesai";
                            form.submit();
                        }
                    });
                });
            });
        </script>

        {{-- alert success --}}
        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: "{{ session('success') }}",
                    timer: 7000,
                    showConfirmButton: true,
                })
            </script>
        @endif

        {{-- alert gagal --}}
        @if (session('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: "{{ session('error') }}"
                })
            </script>
        @endif

        {{-- jquery datatables --}}
        <script>
            initDataTable('#tablePeminjaman');
        </script>
    @endpush
@endsection
