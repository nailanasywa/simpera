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
                                                <input class="form-check-input form-check-primary form-check-glow"
                                                    type="checkbox" id="hariIni" name="hari_ini" value="1"
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
                                            data-nama="{{ $peminjaman->pasien->nama_pasien }}">Selesai
                                        </button>
                                        <button type="button" class="btn btn-outline-info btn-sm btn-detail"
                                            data-bs-toggle="modal" data-bs-target="#modalDetail"
                                            data-norm="{{ $peminjaman->pasien->no_rm }}"
                                            data-nama="{{ $peminjaman->pasien->nama_pasien }}"
                                            data-jk="{{ $peminjaman->pasien->jenis_kelamin }}"
                                            data-umur="{{ $peminjaman->pasien->tanggal_lahir
                                                ? \Carbon\Carbon::parse($peminjaman->pasien->tanggal_lahir)->age . ' Tahun'
                                                : '-' }}"
                                            data-kk="{{ $peminjaman->pasien->nama_kk }}"
                                            data-alamat="{{ $peminjaman->pasien->alamat }}"
                                            data-poli="{{ $peminjaman->jenis_peminjaman == 'kunjungan'
                                                ? $peminjaman->kunjungan?->poli?->nama_poli
                                                : $peminjaman->permintaan?->user?->poli?->nama_poli }}"
                                            data-jeniskunjungan="{{ $peminjaman->kunjungan?->jenis_kunjungan }}"
                                            data-kepesertaan="{{ $peminjaman->kunjungan?->kepesertaan }}">
                                            Lihat Detail
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="modal fade" id="modalDetail" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content border-0 shadow-lg rounded-4">

                                <!-- Header -->
                                <div class="p-4 border-bottom">

                                    <div class="d-flex justify-content-between align-items-center">

                                        <div class="d-flex align-items-center">

                                            <div class="ms-3">
                                                <h3 class="fw-bold text-primary mb-1">
                                                    Detail Peminjaman Rekam Medis
                                                </h3>
                                                <p class="text-muted mb-0">
                                                    Informasi lengkap data pasien
                                                </p>
                                            </div>

                                        </div>

                                        <button type="button" class="btn btn-light rounded-circle" data-bs-dismiss="modal"
                                            style="width:48px;height:48px;">
                                            <i class="bi bi-x-lg"></i>
                                        </button>

                                    </div>

                                </div>

                                <div class="modal-body pt-4">

                                    <!-- Identitas Pasien -->
                                    <div class="card border shadow-sm mb-4">
                                        <div class="card-body">

                                            <div class="row">

                                                <div class="col-md-8">
                                                    <h5 class="fw-bold mb-1" id="detail_nama"></h5>

                                                    <span class="badge bg-light-primary text-primary px-3 py-2 mt-2">
                                                        No. RM :
                                                        <span id="detail_norm"></span>
                                                    </span>
                                                </div>

                                                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                                    <i class="bi bi-hospital fs-1 text-primary opacity-50"></i>
                                                </div>

                                            </div>

                                        </div>
                                    </div>

                                    <!-- Data Pasien -->
                                    <div class="card border shadow-sm mb-4">

                                        <div class="card-header bg-white border-bottom">
                                            <h6 class="mb-0 fw-bold">
                                                <i class="bi bi-person-lines-fill me-2 text-primary"></i>
                                                Data Pasien
                                            </h6>
                                        </div>

                                        <div class="card-body">

                                            <div class="row g-3">

                                                <div class="col-md-6">
                                                    <small class="text-muted">Jenis Kelamin</small>
                                                    <div class="fw-semibold mt-1" id="detail_jk"></div>
                                                </div>

                                                <div class="col-md-6">
                                                    <small class="text-muted">Umur</small>
                                                    <div class="fw-semibold mt-1" id="detail_umur"></div>
                                                </div>

                                                <div class="col-md-6">
                                                    <small class="text-muted">Nama Kepala Keluarga</small>
                                                    <div class="fw-semibold mt-1" id="detail_kk"></div>
                                                </div>

                                                <div class="col-md-6">
                                                    <small class="text-muted">Poli Tujuan</small>
                                                    <div class="fw-semibold mt-1">
                                                        <span class="badge bg-light-info text-info"
                                                            id="detail_poli"></span>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>

                                    <!-- Informasi Kunjungan -->
                                    <div class="card border shadow-sm mb-4">

                                        <div class="card-header bg-white border-bottom">
                                            <h6 class="mb-0 fw-bold">
                                                <i class="bi bi-clipboard2-pulse me-2 text-success"></i>
                                                Informasi Kunjungan
                                            </h6>
                                        </div>

                                        <div class="card-body">

                                            <div class="row">

                                                <div class="col-md-6 mb-3">
                                                    <small class="text-muted">Jenis Kunjungan</small>
                                                    <div class="fw-semibold mt-1" id="detail_jeniskunjungan"></div>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <small class="text-muted">Kepesertaan</small>
                                                    <div class="fw-semibold mt-1">
                                                        <span class="badge bg-light-success text-success"
                                                            id="detail_kepesertaan"></span>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>

                                    <!-- Alamat -->
                                    <div class="card border shadow-sm">

                                        <div class="card-header bg-white border-bottom">
                                            <h6 class="mb-0 fw-bold">
                                                <i class="bi bi-geo-alt-fill me-2 text-danger"></i>
                                                Alamat Pasien
                                            </h6>
                                        </div>

                                        <div class="card-body">

                                            <p class="mb-0" id="detail_alamat"></p>

                                        </div>

                                    </div>

                                </div>

                                <div class="modal-footer border-0 pt-0">
                                    <button class="btn btn-secondary px-4" data-bs-dismiss="modal">
                                        <i class="bi bi-x-circle me-1"></i>
                                        Tutup
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>

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

        <script>
            document.querySelectorAll('.btn-detail').forEach(button => {

                button.addEventListener('click', function() {

                    document.getElementById('detail_norm').textContent =
                        this.dataset.norm;

                    document.getElementById('detail_nama').textContent =
                        this.dataset.nama;

                    document.getElementById('detail_jk').textContent =
                        this.dataset.jk;

                    document.getElementById('detail_umur').textContent =
                        this.dataset.umur;

                    document.getElementById('detail_kk').textContent =
                        this.dataset.kk;

                    document.getElementById('detail_alamat').textContent =
                        this.dataset.alamat;

                    document.getElementById('detail_poli').textContent =
                        this.dataset.poli;

                    document.getElementById('detail_jeniskunjungan').textContent =
                        this.dataset.jeniskunjungan;

                    document.getElementById('detail_kepesertaan').textContent =
                        this.dataset.kepesertaan;

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
