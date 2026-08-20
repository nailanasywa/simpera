@extends('layouts.app')

@section('content')

    <div class="page-heading">
        <h3>Permintaan Peminjaman</h3>
        <p class="text-subtitle text-muted">Halaman Permintaan Rekam Medis</p>
    </div>

    <div class="page-content">
        <div class="card shadow-sm">

            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Riwayat Permintaan</h4>
                <a href="{{ route('petugas.permintaan.create') }}" class="btn btn-outline-primary">
                    <i class="bi bi-plus-circle"></i>
                    Buat Permintaan
                </a>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="tablePermintaan">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No. RM</th>
                                <th>Nama Pasien</th>
                                <th>Keperluan</th>
                                <th>Tanggal Permintaan</th>
                                <th>Status</th>
                                <th>Alasan Penolakan</th>
                                <th>Tanggal Approval</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($permintaans as $permintaan)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $permintaan->pasien->no_rm }}</td>
                                    <td>{{ $permintaan->pasien->nama_pasien }}</td>
                                    <td>{{ $permintaan->keperluan }}</td>
                                    <td>{{ \Carbon\Carbon::parse($permintaan->tanggal_permintaan)->format('d-m-Y H:i') }}
                                    </td>
                                    <td>
                                        @if ($permintaan->status_approval == 'pending')
                                            <span class="badge bg-light-warning">Pending</span>
                                        @elseif ($permintaan->status_approval == 'disetujui')
                                            <span class="badge bg-light-success">Disetujui</span>
                                        @else
                                            <span class="badge bg-light-danger">Ditolak</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($permintaan->status_approval == 'ditolak')
                                            {{ $permintaan->alasan_penolakan }}
                                        @else
                                            Tidak ada
                                        @endif
                                    </td>
                                    <td>
                                        @if ($permintaan->tanggal_approval)
                                            {{ \Carbon\Carbon::parse($permintaan->tanggal_approval)->format('d-m-Y H:i') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <i class="bi bi-folder2-open fs-1 text-secondary"></i>
                                        <br><br>
                                        <span class="text-muted">Belum ada permintaan peminjaman</span>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        {{-- session success --}}
        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ session('success') }}',
                    showConfirmButton: true
                });
            </script>
        @endif

        {{-- jquery datatables --}}
        <script>
            initDataTable('#tablePermintaan');
        </script>
    @endpush

@endsection
