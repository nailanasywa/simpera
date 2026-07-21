@extends('layouts.auth')

@section('title', 'Lupa Password | SIMPERA')

@section('content')
    <div class="text-center mb-5">
        <h2 class="fw-bold text-primary mb-2">
            Lupa Password
        </h2>

        <p class="text-muted">
            Masukkan email akun Anda.
            Link reset password akan dikirim ke email tersebut.
        </p>
    </div>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="mb-4">
            <input type="email" name="email" value="{{ old('email') }}"
                class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan Email" required autofocus>
            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="d-grid mb-3">
            <button type="submit" class="btn btn-primary btn-login">
                Kirim Link Reset Password
            </button>
        </div>
    </form>

    <div class="text-center mt-4">
        <a href="{{ route('login') }}" class="text-decoration-none">
            ← Kembali ke Login
        </a>
    </div>
@endsection
