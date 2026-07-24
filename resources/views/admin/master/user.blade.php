@extends('layouts.app')

@section('content')
    <div class="page-heading">
        <h3>Kelola Data User</h3>
        <p class="text-subtitle text-muted">Halaman Kelola Data User dan Data Poli</p>
    </div>

    <div class="page-content">

        {{-- card data poli --}}
        <section class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h4>Data Poli</h4>
                    </div>
                    <div class="card-body">
                        <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal"
                            data-bs-target="#modalTambahPoli">
                            + Tambah Data Poli
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#modalDaftarPoli">
                            Lihat Daftar Data Poli
                        </button>
                    </div>
                </div>
            </div>
        </section>

        {{-- card data user --}}
        <section class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h4>Data User</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <a href="{{ route('admin.user.create') }}" class="btn btn-primary">
                                + Tambah Data User
                            </a>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle" id="tableUser">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Poli</th>
                                        <th>No. Hp</th>
                                        <th>Created</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->poli->nama_poli ?? '-' }}</td>
                                            <td>{{ $user->no_hp ?? '-' }}</td>
                                            <td>{{ $user->created_at->format('d-m-Y') }}</td>
                                            <td>
                                                <a href="{{ route('admin.user.edit', $user->id) }}"
                                                    class="btn icon icon-left btn-warning btn-sm">
                                                    <i data-feather="edit"></i> Edit</a>
                                                <button type="button"
                                                    class="btn icon icon-left btn-danger btn-sm btn-delete-user"
                                                    data-id="{{ $user->id }}" data-nama="{{ $user->name }}">
                                                    <i data-feather="trash"></i> Hapus
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <form id="formDeleteUser" method="POST" style="display:none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- view modal add poli --}}
    <div class="modal fade" id="modalTambahPoli" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <form action="{{ route('admin.poli.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">
                            Tambah Data Poli
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-label">
                                Nama Poli
                            </label>
                            <input type="text" name="nama_poli"
                                class="form-control @error('nama_poli') is-invalid @enderror"
                                placeholder="Masukkan nama poli" value="{{ old('nama_poli') }}">
                            @error('nama_poli')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <label class="form-label">
                                Email Poli
                            </label>
                            <input type="text" name="email" class="form-control @error('email') is-invalid @enderror"
                                placeholder="Masukkan email poli" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- view modal list poli --}}
    <div class="modal fade" id="modalDaftarPoli" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Daftar Data Poli
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Poli</th>
                                    <th>Email Poli</th>
                                    <th>Updated</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($polis as $poli)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $poli->nama_poli }}</td>
                                        <td>{{ $poli->email }}</td>
                                        <td>{{ $poli->updated_at }}</td>
                                        <td>
                                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#modalEditPoli{{ $poli->id }}">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm btn-delete-poli"
                                                data-id="{{ $poli->id }}" data-nama="{{ $poli->nama_poli }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <form id="formDeletePoli" method="post" style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            Belum ada Data Poli
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- modal edit poli --}}
    @foreach ($polis as $poli)
        <div class="modal fade" id="modalEditPoli{{ $poli->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <form action="{{ route('admin.poli.update', $poli->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title">
                                Edit Data Poli
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Nama Poli</label>
                                <input type="text" name="nama_poli" class="form-control"
                                    value="{{ $poli->nama_poli }}">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    {{-- script --}}
    @push('scripts')
        @if ($errors->has('nama_poli'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    let modal = new bootstrap.Modal(
                        document.getElementById('modalTambahPoli')
                    );

                    modal.show();
                });
            </script>
        @endif

        {{-- sweetalert confirm hapus poli --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const tombolDelete = document.querySelectorAll('.btn-delete-poli');

                tombolDelete.forEach(button => {
                    button.addEventListener('click', function() {
                        let id = this.dataset.id;
                        let nama = this.dataset.nama;

                        Swal.fire({
                            title: 'Yakin ingin Menghapus?',
                            text: 'Data Poli "' + nama + '" akan dihapus.',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#435ebe',
                            cancelButtonColor: '#dc3545',
                            confirmButtonText: 'Ya, Hapus',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                let form = document.getElementById('formDeletePoli');

                                form.action =
                                    "{{ url('admin/poli') }}/" + id + "/delete";

                                form.submit();
                            }
                        });
                    });
                });
            });
        </script>

        {{-- sweetalert confirm hapus user --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const tombolDeleteUser = document.querySelectorAll('.btn-delete-user');
                tombolDeleteUser.forEach(button => {
                    button.addEventListener('click', function() {
                        let id = this.dataset.id;
                        let nama = this.dataset.nama;

                        Swal.fire({
                            title: 'Yakin ingin menghapus?',
                            text: 'Data User "' + nama + '" akan dihapus.',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#435ebe',
                            cancelButtonColor: '#dc3545',
                            confirmButtonText: 'Ya, Hapus',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                let form = document.getElementById('formDeleteUser');
                                form.action = "{{ url('admin/users') }}/" + id + "/delete";
                                form.submit();
                            }
                        });
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
            initDataTable('#tableUser');
        </script>
    @endpush

@endsection
