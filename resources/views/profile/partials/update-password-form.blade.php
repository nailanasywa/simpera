<section>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        @method('PUT')

        <div class="row">

            {{-- Password Lama --}}
            <div class="col-md-12 mb-3">
                <label class="form-label">
                    Password Lama
                </label>

                <input type="password" name="current_password"
                    class="form-control @error('current_password', 'updatePassword') is-invalid @enderror">

                @error('current_password', 'updatePassword')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Password Baru --}}
            <div class="col-md-12 mb-3">
                <label class="form-label">
                    Password Baru
                </label>

                <input type="password" name="password"
                    class="form-control @error('password', 'updatePassword') is-invalid @enderror">

                @error('password', 'updatePassword')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Konfirmasi Password --}}
            <div class="col-md-12 mb-4">
                <label class="form-label">
                    Konfirmasi Password Baru
                </label>

                <input type="password" name="password_confirmation" class="form-control">
            </div>
        </div>

        <div class="text-end">
            <button class="btn btn-primary">
                Update Password
            </button>
        </div>
    </form>
</section>
