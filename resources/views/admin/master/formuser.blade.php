@extends('layouts.app')

@section('content')
    <div class="mb-3">
        <a href="{{ route('admin.user') }}" class="text-decoration-none text-secondary">
            <i class="bi bi-chevron-left"></i>
            Kembali
        </a>
    </div>

    <div class="page-heading">
        <h3>{{ isset($user) ? 'Form Edit Data User' : 'Form Tambah Data User' }}</h3>
        <p class="text-subtitle text-muted">
            {{ isset($user) ? 'Halaman Edit Data User' : 'Halaman Form Data User' }}
        </p>
    </div>

    <div class="page-content">
        <form action="{{ isset($user) ? route('admin.user.update', $user->id) : route('admin.user.store') }}" method="post">
            @csrf
            @if (isset($user))
                @method('PUT')
            @endif
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h4>{{ isset($user) ? 'Edit User' : 'Tambah User' }}</h4>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                {{-- username --}}
                                <div class="col-md-6 mb-3">
                                    <label for="form-label">Username</label>
                                    <input type="text" name="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name', $user->name ?? '') }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{-- email --}}
                                <div class="col-md-6 mb-3">
                                    <label for="form-label">Email</label>
                                    <input type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email', $user->email ?? '') }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{-- role --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Role</label>
                                    <select name="role" id="role"
                                        class="form-select @error('role') is-invalid @enderror">
                                        <option value="">Pilih Role</option>
                                        <option value="admin"
                                            {{ old('role', $user->role ?? '') == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="petugas_poli"
                                            {{ old('role', $user->role ?? '') == 'petugas_poli' ? 'selected' : '' }}>
                                            Petugas Poli</option>
                                        <option value="kepala_puskesmas"
                                            {{ old('role', $user->role ?? '') == 'kepala_puskesmas' ? 'selected' : '' }}>
                                            Kepala Puskesmas</option>
                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{-- poli --}}
                                <div class="col-md-6 mb-3">
                                    <label for="form-label">Poli</label>
                                    <select id="poli_id" name="poli_id"
                                        class="form-select @error('poli_id') is-invalid @enderror">
                                        <option value="">Pilih Poli</option>
                                        @foreach ($polis as $poli)
                                            <option value="{{ $poli->id }}"
                                                {{ old('poli_id', $user->poli_id ?? '') == $poli->id ? 'selected' : '' }}>
                                                {{ $poli->nama_poli }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('poli_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{-- no hp --}}
                                <div class="col-md-6 mb-3">
                                    <label for="form-label">No. HP</label>
                                    <input id="no_hp" type="text" name="no_hp"
                                        class="form-control @error('no_hp') is-invalid @enderror"
                                        value="{{ old('no_hp', $user->no_hp ?? '') }}">
                                    @error('no_hp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{-- NIP --}}
                                <div class="col-md-6 mb-3">
                                    <label for="form-label">NIP</label>
                                    <input id="nip" type="text" name="nip" maxlength="18"
                                        class="form-control @error('nip') is-invalid @enderror"
                                        value="{{ old('nip', $user->nip ?? '') }}">
                                    @error('nip')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{-- password --}}
                                <div class="col-md-6 mb-3">
                                    <label for="form-label">Password</label>
                                    <input type="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror">
                                    @if (isset($user))
                                        <small class="text-danger">Kosongkan password jika tidak ingin mengubah
                                            password</small>
                                    @endif
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{-- konfirmasi password --}}
                                <div class="col-md-6 mb-3">
                                    <label for="form-label">Konfirmasi Password</label>
                                    <input type="password" name="password_confirmation" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="card-footer text-end">
                            <button type="submit"
                                class="btn btn-primary">{{ isset($user) ? 'Update' : 'Simpan' }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const role = document.getElementById('role');
                const poli = document.getElementById('poli_id');
                const nohp = document.getElementById('no_hp');

                function toggleField() {
                    if (role.value === 'petugas_poli') {
                        poli.disabled = false;
                        nohp.disabled = false;
                    } else {
                        poli.value = "";
                        poli.disabled = true;
                        nohp.disabled = false;
                    }
                }
                toggleField();
                role.addEventListener('change', toggleField);
            });
        </script>
    @endpush
@endsection
