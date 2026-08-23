@extends('layouts.app')

@section('content')

    <div class="page-heading">

        <h3>Form Permintaan Peminjaman Rekam Medis</h3>

        <p class="text-subtitle text-muted">

            Halaman Form Permintaan Peminjaman Rekam Medis

        </p>

    </div>

    <div class="page-content">

        <div class="mb-3">

            <a href="{{ route('admin.permintaan') }}" class="text-decoration-none text-secondary">

                <i class="bi bi-chevron-left"></i>

                Kembali

            </a>

        </div>

        <div class="row justify-content-center">

            <div class="col-md-5">

                {{-- FORM CARI PASIEN --}}
                <form action="{{ route('admin.permintaan.create') }}" method="GET">

                    <div class="input-group">

                        <input type="text" class="form-control" name="no_rm" placeholder="Masukkan Nomor RM"
                            value="{{ request('no_rm') }}">

                        <button type="submit" class="btn btn-outline-secondary">

                            <i class="bi bi-search"></i>

                        </button>

                    </div>

                </form>


                @if (request()->filled('no_rm'))

                    @if ($pasien)
                        <div class="card shadow-sm mt-2">

                            <div class="card-body">

                                <table class="table table-borderless">

                                    <tr>

                                        <th width="170">
                                            No RM
                                        </th>

                                        <td>
                                            {{ $pasien->no_rm }}
                                        </td>

                                    </tr>

                                    <tr>

                                        <th>
                                            Nama Pasien
                                        </th>

                                        <td>
                                            {{ $pasien->nama_pasien }}
                                        </td>

                                    </tr>

                                    <tr>

                                        <th>
                                            Nama KK
                                        </th>

                                        <td>
                                            {{ $pasien->nama_kk }}
                                        </td>

                                    </tr>

                                    <tr>

                                        <th>
                                            Alamat
                                        </th>

                                        <td>
                                            {{ $pasien->alamat }}
                                        </td>

                                    </tr>

                                    <tr>

                                        <th>
                                            Status RM
                                        </th>

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


                                <div class="text-center">

                                    @if ($pasien->status_rm == 'tersedia')
                                        <button class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#modalPinjam">

                                            Pinjam

                                        </button>
                                    @else
                                        <button class="btn btn-secondary" disabled>

                                            <i class="bi bi-lock"></i>

                                            Rekam Medis sedang dipinjam

                                        </button>
                                    @endif

                                </div>

                            </div>

                        </div>


                        {{-- MODAL KONFIRMASI --}}
                        <div class="modal fade" id="modalPinjam" tabindex="-1">

                            <div class="modal-dialog modal-dialog-centered">

                                <div class="modal-content">

                                    <form action="{{ route('admin.permintaan.store') }}" method="POST">

                                        @csrf

                                        <input type="hidden" name="pasien_id" value="{{ $pasien?->id }}">


                                        <div class="modal-header">

                                            <h5 class="modal-title">

                                                Konfirmasi Peminjaman

                                            </h5>

                                            <button type="button" class="btn-close" data-bs-dismiss="modal">

                                            </button>

                                        </div>


                                        <div class="modal-body">

                                            {{-- PILIH POLI --}}
                                            <div class="form-group mb-3">

                                                <label class="form-label">

                                                    Poli

                                                </label>

                                                <select name="user_id"
                                                    class="form-select @error('user_id') is-invalid @enderror" required>

                                                    <option value="">

                                                        -- Pilih Poli --

                                                    </option>

                                                    @foreach ($petugasPoli as $petugas)
                                                        <option value="{{ $petugas->id }}"
                                                            {{ old('user_id') == $petugas->id ? 'selected' : '' }}>

                                                            {{ $petugas->poli?->nama_poli ?? '-' }}

                                                        </option>
                                                    @endforeach

                                                </select>

                                                @error('user_id')
                                                    <div class="invalid-feedback">

                                                        {{ $message }}

                                                    </div>
                                                @enderror

                                            </div>


                                            {{-- KEPERLUAN --}}
                                            <div class="form-group mb-3">

                                                <label class="form-label">

                                                    Keperluan

                                                </label>

                                                <textarea name="keperluan" class="form-control @error('keperluan') is-invalid @enderror" rows="2"
                                                    placeholder="Masukkan Keperluan Peminjaman">{{ old('keperluan') }}</textarea>

                                                @error('keperluan')
                                                    <div class="invalid-feedback">

                                                        {{ $message }}

                                                    </div>
                                                @enderror

                                            </div>


                                            {{-- TANGGAL PERMINTAAN --}}
                                            <div class="form-group">

                                                <label class="form-label">

                                                    Tanggal Permintaan

                                                </label>

                                                <input name="tanggal_permintaan" type="datetime-local"
                                                    class="form-control @error('tanggal_permintaan') is-invalid @enderror"
                                                    value="{{ old('tanggal_permintaan', now()->format('Y-m-d\TH:i')) }}">

                                                @error('tanggal_permintaan')
                                                    <div class="invalid-feedback">

                                                        {{ $message }}

                                                    </div>
                                                @enderror

                                            </div>

                                        </div>


                                        <div class="modal-footer">

                                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">

                                                Cancel

                                            </button>

                                            <button type="submit" class="btn btn-primary">

                                                Ajukan Peminjaman

                                            </button>

                                        </div>

                                    </form>

                                </div>

                            </div>

                        </div>
                    @else
                        <div class="text-center mt-5">

                            <i class="bi bi-folder-x" style="font-size:90px"></i>

                            <h3 class="mt-3">

                                Data Tidak Ditemukan

                            </h3>

                        </div>
                    @endif

                @endif

            </div>

        </div>

    </div>


    @push('scripts')
        {{-- SESSION ERROR --}}
        @if (session('error'))
            <script>
                Swal.fire({

                    icon: 'error',

                    title: 'Rekam Medis Tidak Tersedia',

                    text: '{{ session('error') }}',

                    confirmButtonColor: '#435ebe'

                });
            </script>
        @endif


        {{-- SESSION SUCCESS --}}
        @if (session('success'))
            <script>
                Swal.fire({

                    icon: 'success',

                    title: 'Berhasil',

                    text: '{{ session('success') }}',

                    showConfirmButton: true

                });
            </script>
        @endif
    @endpush

@endsection
