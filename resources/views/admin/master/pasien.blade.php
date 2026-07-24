@extends('layouts.app')

@section('content')
    <div class="page-heading">
        <h3>Kelola Data Rekam Medis</h3>
        <p class="text-subtitle text-muted">
            Halaman Kelola Data Pasien
        </p>
    </div>

    <div class="page-content">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h4>Data Pasien</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-flex gap-2">

                                <a href="{{ route('admin.pasien.create') }}" class="btn btn-primary">

                                    <i class="bi bi-plus-circle"></i>
                                    Tambah
                                </a>

                                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalImport">

                                    <i class="bi bi-upload"></i>
                                    Import Excel
                                </button>

                                <a href="{{ route('admin.pasien.template') }}" class="btn btn-info">

                                    <i class="bi bi-download"></i>
                                    Template
                                </a>

                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle" id="tablePasien">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>No. RM</th>
                                        <th>Nama Pasien</th>
                                        <th>Umur</th>
                                        <th>Nama KK</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pasiens as $pasien)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $pasien->no_rm }}</td>
                                            <td>{{ $pasien->nama_pasien }}</td>
                                            <td>{{ $pasien->umur }}</td>
                                            <td>{{ $pasien->nama_kk }}</td>
                                            <td>
                                                <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#modalViewPasien{{ $pasien->id }}">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                <a href="{{ route('admin.pasien.edit', $pasien->id) }}"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button" class="btn btn-danger btn-sm btn-delete"
                                                    data-id="{{ $pasien->id }}" data-nama="{{ $pasien->nama_pasien }}">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalImport" tabindex="-1">

        <div class="modal-dialog">

            <form action="{{ route('admin.pasien.import') }}" method="POST" enctype="multipart/form-data">

                @csrf

                <div class="modal-content">

                    <div class="modal-header">

                        <h5>
                            Import Data Pasien
                        </h5>

                        <button class="btn-close" data-bs-dismiss="modal">
                        </button>

                    </div>

                    <div class="modal-body">

                        <div class="mb-3">

                            <label class="form-label">
                                File Excel
                            </label>

                            <input type="file" name="file" class="form-control" accept=".xlsx,.xls" required>

                        </div>

                        <small class="text-muted">

                            Gunakan file template yang telah disediakan.

                        </small>

                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Batal
                        </button>

                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-upload"></i>
                            Import
                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    {{-- modal view --}}
    @foreach ($pasiens as $pasien)
        <div class="modal fade" id="modalViewPasien{{ $pasien->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            Detail Data Pasien
                        </h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="fw-bold">No. Rekam Medis</label>
                                <input type="text" class="form-control" value="{{ $pasien->no_rm }}" disabled>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="fw-bold">Nama Pasien</label>
                                <input type="text" class="form-control" value="{{ $pasien->nama_pasien }}" disabled>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="fw-bold">Jenis Kelamin</label>
                                <input type="text" class="form-control"
                                    value="{{ $pasien->jenis_kelamin == 'laki_laki' ? 'Laki-laki' : 'Perempuan' }}"
                                    disabled>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="fw-bold">Umur</label>
                                <input type="text" class="form-control" value="{{ $pasien->umur }} Tahun" disabled>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="fw-bold">Tanggal Lahir</label>
                                <input type="text" class="form-control"
                                    value="{{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->format('d-m-Y') }}" disabled>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="fw-bold">Nama Kepala Keluarga</label>
                                <input type="text" class="form-control" value="{{ $pasien->nama_kk }}" disabled>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="fw-bold">Alamat</label>
                                <textarea rows="3" class="form-control" disabled>{{ $pasien->alamat }}</textarea>
                            </div>
                            <div class="col-md-12">
                                <label class="fw-bold">Status Rekam Medis : </label>
                                @if ($pasien->status_rm == 'tersedia')
                                    <span class="badge bg-success">Tersedia</span>
                                @else
                                    <span class="badge bg-danger">Dipinjam</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <form id="deleteForm" method="post" style="display:none;">
        @csrf
        @method('DELETE')
    </form>

    @push('scripts')
        {{-- delete confirm --}}
        <script>
            document.querySelectorAll('.btn-delete').forEach(button => {
                button.addEventListener('click', function() {
                    let id = this.dataset.id;
                    let nama = this.dataset.nama;

                    Swal.fire({
                        title: 'Hapus Data?',
                        text: 'Pasien "' + nama + '" akan dihapus.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#435ebe',
                        cancelButtonColor: '#dc3534',
                        confirmButtonText: 'Ya, Hapus',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let form = document.getElementById('deleteForm');
                            form.action = "/admin/pasien/" + id + "/delete";
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
                    timer: 7000,
                    showConfirmButton: true
                });
            </script>
        @endif

        {{-- session error --}}
        @if (session('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#dc3545'
                });
            </script>
        @endif

        {{-- jquery datatables --}}
        <script>
            initDataTable('#tablePasien');
        </script>

        {{-- session success --}}
        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ session('success') }}',
                    timer: 7000,
                    showConfirmButton: true
                });
            </script>
        @endif

        {{-- session error --}}
        @if (session('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#dc3545'
                });
            </script>
        @endif

        {{-- session import error --}}
        @if (session('import_error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Import Gagal',
                    html: `{!! session('import_error') !!}`,
                    confirmButtonColor: '#dc3545'
                });
            </script>
        @endif
        @if (session('import_result'))
            <script>
                const hasil = @json(session('import_result'));

                Swal.fire({
                    icon: 'success',
                    title: 'Import Selesai',
                    html: `
        <div style="text-align:left">
            ✅ Berhasil ditambahkan : <b>${hasil.berhasil}</b><br>
            ⚠️ Data duplikat : <b>${hasil.duplikat}</b><br>
            ❌ Data gagal : <b>${hasil.gagal}</b>
        </div>
    `
                });
            </script>
        @endif
    @endpush
@endsection
