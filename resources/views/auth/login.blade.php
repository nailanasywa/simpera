@extends('layouts.auth')

@section('title', 'Login - SIMPERA')

@section('content')
    <div class="text-center mb-5">

        <img src="{{ asset('assets/images/logo/Logo_Puskesmas.png') }}" width="75" class="mb-3">

        <h2 class="fw-bold text-primary mb-2">

            SIMPERA

        </h2>

        <p class="text-muted mb-0">

            Sistem Informasi Peminjaman dan
            <br>
            Pengembalian Rekam Medis

        </p>

    </div>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        {{-- Email --}}
        <div class="input-group mb-4">
            <span class="input-group-text bg-white">
                <i class="bi bi-envelope"></i>
            </span>

            <input type="email" name="email" value="{{ old('email') }}"
                class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan Email" required autofocus>
            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Password --}}
        <div class="input-group mb-4">
            <span class="input-group-text bg-white">
                <i class="bi bi-lock"></i>
            </span>
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
