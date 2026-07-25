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
            min-height: 100vh;
            background: linear-gradient(135deg, #2f5fd0 0%, #4e73df 45%, #7fa7ff 100%);
        }

        .auth-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .auth-card {
            border: none;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, .18);
            backdrop-filter: blur(8px);
        }

        .auth-image-wrapper {
            position: relative;
            height: 100%;
        }

        .auth-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .auth-image-wrapper::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(rgba(24, 52, 124, .35),
                    rgba(24, 52, 124, .55));
        }

        .auth-form {
            padding: 55px 60px;
        }

        @media(max-width:992px) {

            .auth-form {
                padding: 40px;
            }

        }

        @media(max-width:576px) {

            .auth-form {
                padding: 30px 22px;
            }

        }

        .form-control {
            height: 52px;
            border-radius: 14px;
            border: 1px solid #d9dfe7;
            padding-left: 18px;
            transition: .25s;
        }

        .form-control:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 .18rem rgba(78, 115, 223, .15);
        }

        .btn-login {

            height: 52px;

            border-radius: 14px;

            font-weight: 600;

            font-size: 16px;

            transition: .3s;

        }

        .btn-login:hover {

            transform: translateY(-2px);

            box-shadow: 0 10px 25px rgba(78, 115, 223, .35);

        }

        .input-group-text {

            border-radius: 14px 0 0 14px;

            border-right: none;

        }

        .input-group-text i {
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
        }

        .input-group .form-control {

            border-left: none;

        }

        .input-group-text:last-child {
            border-left: 0;
            border-right: 1px solid #dee2e6;
        }

        #togglePassword {
            cursor: pointer;
            background: #fff;
        }

        #togglePassword i {
            line-height: 1;
        }

        #togglePassword:hover i {
            color: #0d6efd;
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
                            <div class="auth-image-wrapper">
                                <img src="{{ asset('assets/images/auth/login.jpeg') }}" class="auth-image"
                                    alt="Login">
                            </div>
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
