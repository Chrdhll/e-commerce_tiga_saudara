<div class="card-header bg-white py-3">
    <h5 class="mb-0 text-primary">Informasi Profil</h5>
    <p class="small text-muted mb-0">Perbarui nama dan alamat email akun Anda.</p>
</div>
<div class="card-body p-4">
    
    <form id="send-verification" method="post" action="{{ route('verification.send') }}" class="d-none">
        @csrf
    </form>

    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required autofocus>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

         <!-- Nomor Telepon -->
        <div class="mb-3">
            <label for="phone_number" class="form-label">Nomor Telepon</label>
            <input id="phone_number" name="phone_number" type="tel" class="form-control @error('phone_number') is-invalid @enderror" value="{{ old('phone_number', $user->phone_number) }}" placeholder="Contoh: 08123456789">
            @error('phone_number')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Alamat -->
        <div class="mb-3">
            <label for="address" class="form-label">Alamat</label>
            <textarea id="address" name="address" class="form-control @error('address') is-invalid @enderror" rows="3" placeholder="Masukkan alamat lengkap Anda">{{ old('address', $user->address) }}</textarea>
            @error('address')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="mb-3">
                <p class="small text-muted">
                    Email Anda belum terverifikasi.
                    <button form="send-verification" class="btn btn-link p-0 m-0 align-baseline text-decoration-none">
                        Kirim ulang email verifikasi
                    </button>
                </p>
                @if (session('status') === 'verification-link-sent')
                    <div class="alert alert-success small py-2">Link verifikasi baru telah dikirim.</div>
                @endif
            </div>
        @endif
        <div class="d-flex justify-content-end align-items-center">
            @if (session('status') === 'profile-updated')
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