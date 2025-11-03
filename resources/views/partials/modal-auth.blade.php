<!-- Auth Modal -->
<div class="modal fade" id="authModal" tabindex="-1" aria-labelledby="authModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0">
            
            <!-- Header Modal -->
            <div class="modal-header border-bottom-0 p-4">
                <h5 class="modal-title fs-4 text-primary" id="authModalLabel">
                    <span x-show="mode === 'login'">Masuk</span>
                    <span x-show="mode === 'register'">Daftar</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Body Modal -->
            <div class="modal-body p-4 pt-0">
                
                <!-- Tampilkan Error Validasi (PENTING) -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <!-- Form Login -->
                <form method="POST" action="{{ route('login') }}" x-show="mode === 'login'">
                    @csrf
                    <div class="mb-3">
                        <label for="login_email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="login_email" placeholder="nama@email.com" required value="{{ old('email') }}">
                    </div>
                    <div class="mb-3">
                        <label for="login_password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="login_password" placeholder="Masukkan password" required>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                            <label class="form-check-label small" for="remember_me">Ingat saya</label>
                        </div>
                        <a href="{{ route('password.request') }}" class="small text-primary text-decoration-none">Lupa password?</a>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-2 fs-6">Masuk</button>
                </form>

                <!-- Form Register -->
                <form method="POST" action="{{ route('register') }}" x-show="mode === 'register'">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Masukkan nama lengkap" required value="{{ old('name') }}">
                    </div>
                    <div class="mb-3">
                        <label for="register_email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="register_email" placeholder="nama@email.com" required value="{{ old('email') }}">
                    </div>
                    <div class="mb-3">
                        <label for="register_password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="register_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-2 fs-6">Daftar</button>
                </form>

                <!-- Pemisah "Atau" -->
                <div class="d-flex align-items-center my-4">
                    <hr class="flex-grow-1">
                    <span class="px-3 text-muted">Atau</span>
                    <hr class="flex-grow-1">
                </div>

                <!-- Tombol Google Auth -->
                <a href="{{ route('google.login') }}" class="btn btn-outline-secondary w-100 py-2 fs-6 d-flex align-items-center justify-content-center">
                    <i class="bi bi-google text-danger me-2"></i>
                    <span x-show="mode === 'login'">Masuk dengan Google</span>
                    <span x-show="mode === 'register'">Daftar dengan Google</span>
                </a>
                
                <!-- Tombol Ganti Mode -->
                <div class="text-center mt-4">
                    <p class="text-muted">
                        <span x-show="mode === 'login'">Belum punya akun?</span>
                        <span x-show="mode === 'register'">Sudah punya akun?</span>
                        <button type="button" class="btn btn-link text-primary p-0 m-0 align-baseline" 
                                @click="mode = (mode === 'login' ? 'register' : 'login')">
                            <span x-show="mode === 'login'">Daftar sekarang</span>
                            <span x-show="mode === 'register'">Masuk</span>
                        </button>
                    </p>
                </div>

            </div>
        </div>
    </div>
</div>
