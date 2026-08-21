@extends('layouts.app')

@section('title', 'Pengaturan Notifikasi')

@section('content')

    <div class="page-heading">

        <div class="page-title">
            <div class="row">

                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Pengaturan Notifikasi</h3>

                    <p class="text-subtitle text-muted">
                        Atur waktu pengiriman notifikasi sistem
                    </p>
                </div>

                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">

                        <ol class="breadcrumb">

                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">
                                    Dashboard
                                </a>
                            </li>

                            <li class="breadcrumb-item active">
                                Pengaturan Notifikasi
                            </li>

                        </ol>

                    </nav>
                </div>

            </div>
        </div>

        <section class="section">

            <div class="card">

                <div class="card-header">
                    <h4 class="card-title">
                        Daftar Notifikasi
                    </h4>
                </div>

                <div class="card-body">

                    @if (session('success'))
                        <div id="success-alert" class="alert alert-success alert-dismissible fade show">

                            {{ session('success') }}

                            <button type="button" class="btn-close" data-bs-dismiss="alert">
                            </button>

                        </div>

                        <script>
                            setTimeout(function() {
                                const alertElement = document.getElementById('success-alert');

                                if (alertElement) {
                                    alertElement.classList.remove('show');

                                    setTimeout(function() {
                                        alertElement.remove();
                                    }, 150);
                                }
                            }, 2000);
                        </script>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="table-responsive">

                        <table class="table table-hover">

                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Jenis Notifikasi</th>
                                    <th>Waktu</th>
                                    <th>Status</th>
                                    <th width="120">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>

                                @forelse ($notifikasis as $notifikasi)
                                    <tr>

                                        <td>
                                            {{ $loop->iteration }}
                                        </td>

                                        <td>
                                            @if ($notifikasi->jenis_notifikasi == 'pengingat_pengembalian')
                                                Pengingat Pengembalian
                                            @else
                                                {{ ucwords(str_replace('_', ' ', $notifikasi->jenis_notifikasi)) }}
                                            @endif
                                        </td>

                                        <td>
                                            {{ \Carbon\Carbon::parse($notifikasi->waktu)->format('H:i') }} WIB
                                        </td>

                                        <td>
                                            @if ($notifikasi->status)
                                                <span class="badge bg-success">
                                                    Aktif
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">
                                                    Nonaktif
                                                </span>
                                            @endif
                                        </td>

                                        <td>

                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#modalEdit{{ $notifikasi->id }}">

                                                <i class="bi bi-pencil"></i>
                                                Edit

                                            </button>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">

                                            Belum ada pengaturan notifikasi.

                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </section>

    </div>


    {{-- MODAL EDIT --}}
    @foreach ($notifikasis as $notifikasi)
        <div class="modal fade" id="modalEdit{{ $notifikasi->id }}" tabindex="-1" aria-hidden="true">

            <div class="modal-dialog modal-dialog-centered">

                <div class="modal-content">

                    <form action="{{ route('admin.notifikasi.update', $notifikasi->id) }}" method="POST">

                        @csrf
                        @method('PUT')

                        <div class="modal-header">

                            <h5 class="modal-title">
                                Edit Pengaturan Notifikasi
                            </h5>

                            <button type="button" class="btn-close" data-bs-dismiss="modal">
                            </button>

                        </div>

                        <div class="modal-body">

                            <div class="mb-3">

                                <label class="form-label fw-bold">
                                    Jenis Notifikasi
                                </label>

                                <input type="text" class="form-control"
                                    value="{{ $notifikasi->jenis_notifikasi == 'pengingat_pengembalian'
                                        ? 'Pengingat Pengembalian'
                                        : ucwords(str_replace('_', ' ', $notifikasi->jenis_notifikasi)) }}"
                                    disabled>

                            </div>


                            <div class="mb-3">

                                <label class="form-label fw-bold">
                                    Waktu Pengiriman
                                </label>

                                <input type="time" name="waktu" class="form-control"
                                    value="{{ \Carbon\Carbon::parse($notifikasi->waktu)->format('H:i') }}" required>

                            </div>


                            <div class="mb-3">

                                <label class="form-label fw-bold">
                                    Status
                                </label>

                                <select name="status" class="form-select" required>

                                    <option value="1" {{ $notifikasi->status ? 'selected' : '' }}>
                                        Aktif
                                    </option>

                                    <option value="0" {{ !$notifikasi->status ? 'selected' : '' }}>
                                        Nonaktif
                                    </option>

                                </select>

                            </div>

                        </div>

                        <div class="modal-footer">

                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Batal
                            </button>

                            <button type="submit" class="btn btn-primary">

                                <i class="bi bi-save"></i>
                                Simpan

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>
    @endforeach

@endsection
