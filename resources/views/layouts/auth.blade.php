<!DOCTYPE html>
<html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>@yield('title', 'SIMPERA')</title>

        <link rel="shortcut icon" href="{{ asset('assets/compiled/svg/favicon.svg') }}">
        {{-- Bootstrap --}}
        <link rel="stylesheet" href="{{ asset('assets/compiled/css/app.css') }}">
        {{-- Bootstrap Icons --}}
        <link rel="stylesheet" href="{{ asset('assets/extensions/bootstrap-icons/font/bootstrap-icons.min.css') }}">
        {{-- SweetAlert --}}
        <link rel="stylesheet" href="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.css') }}">

        <style>
            body {
                background: #4e73df;
                min-height: 100vh;
            }

            .auth-wrapper {
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .auth-card {
                border: none;
                border-radius: 18px;
                overflow: hidden;
            }

            .auth-image {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .auth-form {
                padding: 50px;
            }

            .form-control {
                border-radius: 50px;
            }

            .btn-login {
                border-radius: 50px;
                padding: 12px;
            }

            @media(max-width:991px) {

                .auth-form {
                    padding: 35px;
                }

            }
        </style>

        @stack('styles')
    </head>

    <body>
        <div class="container auth-wrapper">
            <div class="row justify-content-center w-100">
                <div class="col-xl-10 col-lg-11">
                    <div class="card shadow-lg auth-card">
                        <div class="row g-0">
                            {{-- Gambar --}}
                            <div class="col-lg-6 d-none d-lg-block">
                                <img src="{{ asset('assets/images/auth/login.jpeg') }}" class="auth-image" alt="Login">
                            </div>
                            {{-- Form --}}
                            <div class="col-lg-6">
                                <div class="auth-form">
                                    @yield('content')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/extensions/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>

        @stack('scripts')
    </body>
</html>
