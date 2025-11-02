<div class="card-header bg-danger bg-opacity-10 py-3">
    <h5 class="mb-0 text-danger">Hapus Akun</h5>
    <p class="small text-muted mb-0">Setelah akun Anda dihapus, semua data akan hilang permanen.</p>
</div>
<div class="card-body p-4">
    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
        Hapus Akun Saya
    </button>
</div>

<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')

                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="deleteAccountModalLabel">Konfirmasi Hapus Akun</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus akun Anda? Setelah dihapus, semua data tidak dapat dikembalikan. Silakan masukkan password Anda untuk mengonfirmasi.</p>
                    
                    <div class="mb-3">
                        <label for="password_delete" class="form-label">Password</label>
                        <input id="password_delete" name="password" type="password" class="form-control @error('password', 'deleteUser') is-invalid @enderror" required>
                        @error('password', 'deleteUser')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus Akun</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Script untuk menangani error modal (agar modal terbuka jika ada error) --}}
@if($errors->deleteUser->isNotEmpty())
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            var myModal = new bootstrap.Modal(document.getElementById('deleteAccountModal'));
            myModal.show();
        });
    </script>
@endif
