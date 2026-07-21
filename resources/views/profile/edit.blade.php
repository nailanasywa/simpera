@extends('layouts.app')

@section('content')
    <div class="page-heading">
        <h3>My Profile</h3>

        <p class="text-subtitle text-muted">
            Kelola informasi akun yang sedang login.
        </p>
    </div>

    {{-- session success --}}
    @if (session('status') == 'profile-updated')
        <div class="alert alert-success">
            Profil berhasil diperbarui.
        </div>
    @endif

    <div class="page-content">
        <div class="row">
            <div class="col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h4>Informasi Akun</h4>
                    </div>
                    <div class="card-body">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h4>Ubah Password</h4>
                    </div>
                    <div class="card-body">
                        @if (session('status') == 'password-updated')
                            <div class="alert alert-success mb-3">
                                Password berhasil diperbarui.
                            </div>
                        @endif
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
