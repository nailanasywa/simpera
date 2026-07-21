@extends('layouts.app')

@section('content')

    <div class="page-heading">
        <h3>Kelola Transaksi Kunjungan</h3>
        <p class="text-subtitle text-muted">
            Halaman Kelola Data Transaksi Kunjungan
        </p>
    </div>

    <div class="page-content">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <form method="GET" action="{{ route('admin.kunjungan') }}">
                    <div class="input-group mb-2">
                        <input type="text" name="no_rm" class="form-control" placeholder="Masukkan No.RM"
                            value="{{ request('no_rm') }}">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>

                @if (request()->filled('no_rm'))
                    @if ($pasien)
                        {{-- card pasien --}}
                        <div class="card shadow-sm mt-2">
                            <div class="card-body">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="180">No. RM</th>
                                        <td>{{ $pasien->no_rm }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nama Pasien</th>
                                        <td>{{ $pasien->nama_pasien }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nama KK</th>
                                        <td>{{ $pasien->nama_kk }}</td>
                                    </tr>
                                    <tr>
                                        <th>Alamat</th>
                                        <td>{{ $pasien->alamat }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status RM</th>
                                        <td>
                                            @if ($pasien->status_rm == 'tersedia')
                                                <span class="badge bg-light-success">
                                                    <i class="bi bi-check-circle"></i>
                                                    Tersedia
                                                </span>
                                            @else
                                                <span class="badge bg-light-danger">
                                                    <i class="bi bi-lock-fill"></i>
                                                    Dipinjam
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                                <div class="text-center mt-3">
                                    @if ($pasien->status_rm == 'tersedia')
                                        <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modalTambahKunjungan">
                                            Tambah Kunjungan
                                        </button>
                                    @else
                                        <button class="btn btn-secondary" type="button" disabled>
                                            <i class="bi bi-lock-fill"></i>
                                            Rekam Medis sedang dipinjam
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- modal tambah kunjungan --}}
                        <div class="modal fade" id="modalTambahKunjungan" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form action="{{ route('admin.kunjungan.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="pasien_id" value="{{ optional($pasien)->id }}">
                                        <div class="modal-header">
                                            <h5 class="modal-title">
                                                Tambah Kunjungan
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal">
                                            </button>
                                        </div>

                                        <div class="modal-body">
                                            {{-- poli tujuan --}}
                                            <div class="form-group">
                                                <label class="form-label">
                                                    Poli Tujuan
                                                </label>
                                                <select name="poli_id"
                                                    class="form-select @error('poli_id') is-invalid @enderror">
                                                    <option value="">Pilih Poli</option>
                                                    @foreach ($polis as $poli)
                                                        <option value="{{ $poli->id }}">{{ $poli->nama_poli }}</option>
                                                    @endforeach
                                                </select>
                                                @error('poli_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            {{-- kepesertaan --}}
                                            <div class="form-group">
                                                <label class="form-label">
                                                    Kepesertaan
                                                </label>
                                                <select name="kepesertaan"
                                                    class="form-select @error('kepesertaan') is-invalid @enderror">
                                                    <option value="">Pilih Kepesertaan</option>
                                                    <option value="bpjs">BPJS</option>
                                                    <option value="umum">Umum</option>
                                                </select>
                                                @error('kepesertaan')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            {{-- tanggal --}}
                                            <div class="form-group">
                                                <label class="form-label">
                                                    Tanggal Kunjungan
                                                </label>
                                                <input type="date" name="tanggal_kunjungan"
                                                    class="form-control @error('tanggal_kunjungan') is-invalid @enderror"
                                                    value="{{ now()->format('Y-m-d') }}">
                                            </div>
                                            @error('tanggal_kunjungan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                                Batal
                                            </button>
                                            <button type="submit" class="btn btn-primary">
                                                Simpan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center mt-5">
                            <i class="bi bi-folder-x" style="font-size:100px"></i>
                            <h2 class="mt-3">Data Tidak Ditemukan</h2>
                        </div>
                    @endif
                @endif

                <p class="text-center text-muted">
                    Cari pasien dengan nomor Rekam Medik
                    <br>
                    untuk melakukan Kunjungan
                </p>
            </div>
        </div>

        @if (request()->filled('no_rm') && $pasien)
            <div class="row mt-4">
                <div class="col-md-12">
                    {{-- riwayat kunjungan pasien --}}
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h5>Riwayat Kunjungan</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle" id="tableKunjungan">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Poli</th>
                                            <th>Jenis Kunjungan</th>
                                            <th>Kepesertaan</th>
                                            <th>Petugas</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pasien->kunjungan as $kunjungan)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->format('d-m-Y') }}
                                                </td>
                                                <td>{{ $kunjungan->poli->nama_poli }}</td>
                                                <td>{{ ucfirst($kunjungan->jenis_kunjungan) }}</td>
                                                <td>{{ strtoupper($kunjungan->kepesertaan) }}</td>
                                                <td>{{ $kunjungan->creator->name }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @push('scripts')
        {{-- session success --}}
        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ session('success') }}',
                    timer: 7000,
                    showConfirmButton: true
                });
            </script>
        @endif

        {{-- session error --}}
        @if (session('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Rekam Medis tidak tersedia',
                    text: '{{ session("error") }}'
                });
            </script>
        @endif

        {{-- jquery datatables --}}
        <script>
            initDataTable('#tableKunjungan');
        </script>
    @endpush
@endsection
