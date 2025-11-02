<div class="card-header bg-white py-3">
    {{-- LOGIKA 1: Ganti Judul & Deskripsi --}}
    @if (auth()->user()->password === null)
        <h5 class="mb-0 text-primary">Buat Password</h5>
        <p class="small text-muted mb-0">Akun Anda hanya menggunakan Google Login. Buat password untuk bisa login manual.</p>
    @else
        <h5 class="mb-0 text-primary">Perbarui Password</h5>
        <p class="small text-muted mb-0">Pastikan akun Anda menggunakan password yang panjang dan acak.</p>
    @endif
</div>
<div class="card-body p-4">
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        {{-- LOGIKA 2: Sembunyikan field ini jika password user NULL --}}
        @if (auth()->user()->password !== null)
            <div class="mb-3">
                <label for="current_password" class="form-label">Password Saat Ini</label>
                <input id="current_password" name="current_password" type="password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" required>
                @error('current_password', 'updatePassword')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        @endif

        {{-- Field ini selalu tampil --}}
        <div class="mb-3">
            <label for="password" class="form-label">Password Baru</label>
            <input id="password" name="password" type="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror" required>
            @error('password', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Field ini selalu tampil --}}
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
            <input id="password_confirmation" name="password_confirmation" type="password" class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror" required>
            @error('password_confirmation', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-end align-items-center">
            @if (session('status') === 'password-updated')
                <span class="text-success small me-3"
                      x-data="{ show: true }"
                      x-show="show"
                      x-transition
                      x-init="setTimeout(() => show = false, 2000)">Tersimpan.</span>
            @endif
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
</div>