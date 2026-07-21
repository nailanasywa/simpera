@extends('layouts.auth')

@section('title', 'Login - SIMPERA')

@section('content')
    <div class="d-flex align-items-center justify-content-center mb-4">
        <img src="{{ asset('assets/images/logo/Logo_Puskesmas.png') }}" alt="Logo Puskesmas"
            style="height:70px;width:auto;margin-right:18px;">
        <div class="text-start">
            <h3 class="fw-bold text-primary mb-1">
                SIMPERA
            </h3>

            <small class="text-muted">
                Sistem Informasi Peminjaman
                <br>
                dan Pengembalian Rekam Medis
            </small>
        </div>
    </div>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        {{-- Email --}}
        <div class="mb-4">
            <input type="email" name="email" value="{{ old('email') }}"
                class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan Email" required autofocus>
            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Password --}}
        <div class="mb-3">
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                placeholder="Masukkan Password" required>
            @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label" for="remember">
                    Ingat Saya
                </label>
            </div>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="small text-decoration-none">
                    Lupa Password?
                </a>
            @endif
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary btn-login">
                Login
            </button>
        </div>
    </form>
@endsection
