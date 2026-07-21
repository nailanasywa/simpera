<section>

    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PATCH')

        <div class="row">

            {{-- Username --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">
                    Username
                </label>

                <input
                    type="text"
                    name="name"
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $user->name) }}"
                    required
                >

                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Email --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email', $user->email) }}"
                    required
                >

                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Role --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">
                    Role
                </label>

                <input
                    type="text"
                    class="form-control"
                    value="{{ ucfirst(str_replace('_',' ', $user->role)) }}"
                    disabled
                >
            </div>

            {{-- Poli --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">
                    Poli
                </label>

                <input
                    type="text"
                    class="form-control"
                    value="{{ $user->poli->nama_poli ?? '-' }}"
                    disabled
                >
            </div>

            {{-- No HP --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">
                    No. HP
                </label>

                <input
                    type="text"
                    name="no_hp"
                    class="form-control @error('no_hp') is-invalid @enderror"
                    value="{{ old('no_hp', $user->no_hp) }}"
                >
                @error('no_hp')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <div class="text-end">
            <button class="btn btn-primary">
                Simpan Perubahan
            </button>
        </div>
    </form>
</section>
