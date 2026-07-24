@extends('layouts.app')

@section('content')
    <div class="mb-3">
        <a href="{{ route('admin.pasien') }}" class="text-decoration-none text-secondary">
            <i class="bi bi-chevron-left"></i>
            Kembali
        </a>
    </div>

    <div class="page-heading">
        <h3>{{ isset($pasien) ? 'Form Edit Data Pasien' : 'Form Tambah Data Pasien' }}</h3>
        <p class="text-subtitle text-muted">
            {{ isset($pasien) ? 'Halaman Form Edit Data Pasien' : 'Halaman Form Tambah Data Pasien' }}
        </p>
    </div>

    <div class="page-content">
        <form action="{{ isset($pasien) ? route('admin.pasien.update', $pasien->id) : route('admin.pasien.store') }}"
            method="post">
            @csrf
            @if (isset($pasien))
                @method('PUT')
            @endif
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h4>{{ isset($pasien) ? 'Edit Data Pasien' : 'Tambah Data Pasien' }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                {{-- left --}}
                                <div class="col-md-6">
                                    {{-- no rm --}}
                                    <div class="form-group">
                                        <label for="form-label">No RM</label>

                                        <input type="text" class="form-control"
                                            value="{{ isset($pasien) ? $pasien->no_rm : 'Generate Otomatis' }}"
                                            id="disabledInput" disabled>
                                    </div>

                                    {{-- tangal lahir --}}
                                    <div class="form-group">
                                        <label for="form-label">Tanggal Lahir</label>
                                        <input type="date" id="tanggal_lahir" name="tanggal_lahir"
                                            class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                            value="{{ old('tanggal_lahir', $pasien->tanggal_lahir ?? '') }}">
                                        @error('tanggal_lahir')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- nama kk --}}
                                    <div class="form-group">
                                        <label for="form-label">Nama Kepala Keluarga</label>
                                        <input type="text" name="nama_kk"
                                            class="form-control @error('nama_kk') is-invalid @enderror"
                                            value="{{ old('nama_kk', $pasien->nama_kk ?? '') }}">
                                        @error('nama_kk')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- right --}}
                                <div class="col-md-6">
                                    {{-- nama pasien --}}
                                    <div class="form-group">
                                        <label for="form-label">Nama Pasien</label>
                                        <input type="text" name="nama_pasien"
                                            value="{{ old('nama_pasien', $pasien->nama_pasien ?? '') }}"
                                            class="form-control @error('nama_pasien') is-invalid @enderror">
                                        @error('nama_pasien')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- umur --}}
                                    <div class="form-group">
                                        <label for="form-label">Umur</label>
                                        <input type="text" id="umur" class="form-control"
                                            value="{{ isset($pasien) ? $pasien->umur . ' Tahun' : '' }}" disabled>
                                    </div>

                                    {{-- jenis kelamin --}}
                                    <div class="form-group">
                                        <label for="form-label">Jenis Kelamin</label>
                                        <select name="jenis_kelamin"
                                            class="form-select @error('jenis_kelamin') is-invalid @enderror">
                                            <option value="">Pilih jenis kelamin</option>
                                            <option value="laki_laki"
                                                {{ old('jenis_kelamin', $pasien->jenis_kelamin ?? '') == 'laki_laki' ? 'selected' : '' }}>
                                                Laki-laki</option>
                                            <option value="perempuan"
                                                {{ old('jenis_kelamin', $pasien->jenis_kelamin ?? '') == 'perempuan' ? 'selected' : '' }}>
                                                Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                {{-- alamat --}}
                                <div class="form-group">
                                    <label for="form-label">Alamat</label>
                                    <textarea name="alamat" rows="3" class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat', $pasien->alamat ?? '') }}</textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button type="submit"
                                class="btn btn-primary">{{ isset($pasien) ? 'Update' : 'Simpan' }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

{{-- script --}}
@push('scripts')
    <script>
        document.getElementById('tanggal_lahir').addEventListener('change', function() {
            let born = new Date(this.value);
            let now = new Date();

            let age = now.getFullYear() - born.getFullYear();

            let month = now.getMonth() - born.getMonth();

            if (month < 0 || (
                    month === 0 && now.getDate() < born.getDate()
                )) {
                age--;
            }

            document.getElementById('umur').value = age + ' Tahun';
        });
    </script>
@endpush
