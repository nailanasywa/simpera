<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SIMPERA</title>
    <link rel="shortcut icon" href="{{ asset('assets/compiled/svg/favicon.svg') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/iconly.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.css') }}">
    <style>
        .dashboard-card {
            border: 0;
            border-radius: 18px;
            overflow: hidden;
            position: relative;
            transition: .3s ease;
        }

        .dashboard-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: #435ebe;
        }

        .dashboard-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 28px rgba(0, 0, 0, .12);
        }

        .dashboard-icon {
            width: 70px;
            height: 70px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .dashboard-icon i {
            font-size: 32px;
            line-height: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .dashboard-card:hover .dashboard-icon {
            transform: scale(1.08);
        }

        .pending-item {
            border-left: 5px solid #ffc107;
            border-radius: 12px;
            transition: .3s;
        }

        .pending-item:hover {
            background: #f8f9fa;
        }
    </style>
    @stack('styles')
</head>

<body>
    <div id="app">
        {{-- sidebar --}}
        @include('layouts.sidebar')

        <div id="main" class="layout-navbar navbar-fixed">
            @include('layouts.navbar')
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div id="main-content">
                @yield('content')
            </div>
        </div>
    </div>

    {{-- script --}}
    <script src="{{ asset('assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/compiled/js/app.js') }}"></script>
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/static/js/pages/datatables.js') }}"></script>

    @stack('scripts')

</body>

</html>
