@extends('layouts.app')

@section('content')
    <div class="page-heading">
        <h3>Approval Permintaan Peminjaman Rekam Medis</h3>
        <p class="text-subtitle text-muted">
            Halaman Approval Permintaan Peminjaman Rekam Medis
        </p>
    </div>

    <div class="page-content">
        <div class="card shadow-sm">
            <div class="card-header">
                <h4>Daftar Permintaan</h4>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="tableApproval">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No. RM</th>
                                <th>Nama Pasien</th>
                                <th>Poli</th>
                                <th>Keperluan</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permintaans as $permintaan)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $permintaan->pasien?->no_rm }}</td>
                                    <td>{{ $permintaan->pasien?->nama_pasien }}</td>
                                    <td>{{ $permintaan->user?->poli?->nama_poli ?? '-' }}</td>
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
                                        <button class="btn icon icon-left btn-info btn-sm" type="button"
                                            data-bs-toggle="modal" data-bs-target="#modalDetail{{ $permintaan->id }}">
                                            <i class="bi bi-info-circle"></i>
                                            Detail
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @foreach ($permintaans as $permintaan)
                        <div class="modal fade" id="modalDetail{{ $permintaan->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">
                                            Detail Permintaan Peminjaman
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">No. Rekam Medis</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $permintaan->pasien?->no_rm }}" disabled>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Nama Pasien</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $permintaan->pasien?->nama_pasien }}" disabled>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Poli</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $permintaan->user?->poli?->nama_poli }}" disabled>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Status</label>
                                                <input type="text" class="form-control"
                                                    value="{{ ucfirst($permintaan->status_approval) }}" disabled>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label fw-bold">Keperluan</label>
                                                <textarea rows="3" class="form-control" disabled>{{ $permintaan->keperluan }}</textarea>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label fw-bold">
                                                    Alasan Penolakan <span class="text-danger">*</span>
                                                </label>

                                                <textarea rows="3" class="form-control" name="alasan_penolakan" form="formReject{{ $permintaan->id }}"
                                                    placeholder="Masukkan alasan penolakan" {{ $permintaan->status_approval != 'pending' ? 'disabled' : '' }} required>{{ $permintaan->alasan_penolakan }}</textarea>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label fw-bold">Tanggal Permintaan</label>
                                                <input type="text" class="form-control"
                                                    value="{{ \Carbon\Carbon::parse($permintaan->tanggal_permintaan)->format('d-m-Y H:i') }}"
                                                    disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">

                                        <form action="{{ route('admin.approval.reject', $permintaan->id) }}" method="POST"
                                            id="formReject{{ $permintaan->id }}" class="d-inline">
                                            @csrf
                                            @method('PUT')

                                            <button type="submit" class="btn btn-danger"
                                                {{ $permintaan->status_approval != 'pending' ? 'disabled' : '' }}>
                                                Tolak
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.approval.approve', $permintaan->id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')

                                            <button type="submit" class="btn btn-success"
                                                {{ $permintaan->status_approval != 'pending' ? 'disabled' : '' }}>
                                                Setuju
                                            </button>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <form id="formReject" method="post" style="display:none">
        @csrf
        @method('PUT')
    </form>

    @push('scripts')
        <script>
            document.querySelectorAll('.btn-reject').forEach(button => {
                button.addEventListener('click', function() {
                    let id = this.dataset.id;
                    let nama = this.dataset.nama;

                    Swal.fire({
                        title: 'Tolak Permintaan?',
                        text: 'Permintaan peminjaman atas nama "' + nama + '" akan ditolak.',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, Tolak',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let form = document.getElementById('formReject');
                            form.action = "/admin/approval/" + id + "/reject";
                            form.submit();
                        }
                    });
                });
            });
        </script>

        {{-- session success --}}
        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ session('success') }}',
                    showConfirmButton: true,
                });
            </script>
        @endif

        {{-- session error --}}
        @if (session('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: '{{ session('error') }}'
                });
            </script>
        @endif

        {{-- jquery datatables --}}
        <script>
            initDataTable('#tableApproval');
        </script>
    @endpush
@endsection
