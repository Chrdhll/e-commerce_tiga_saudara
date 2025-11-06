{{-- Ini adalah HTML untuk Bootstrap Toast --}}
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1100">
    <div id="globalToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
        <div class="toast-header">
            {{-- Icon dan Judul akan diisi oleh JS --}}
            <i id="globalToastIcon" class="bi fs-5 me-2"></i>
            <strong id="globalToastTitle" class="me-auto"></strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body bg-white" id="globalToastMessage">
            {{-- Pesan akan diisi oleh JS --}}
        </div>
    </div>
</div>

<script>
    // 1. Tunggu sampai semua HTML & JS (termasuk app.js) selesai di-load
    document.addEventListener('DOMContentLoaded', () => {
        
        // 2. Ambil elemen-elemen toast-nya
        const toastEl = document.getElementById('globalToast');
        if (!toastEl) return; // Keluar jika elemen tidak ditemukan

        const titleEl = document.getElementById('globalToastTitle');
        const iconEl = document.getElementById('globalToastIcon');
        const headerEl = toastEl.querySelector('.toast-header');
        const messageEl = document.getElementById('globalToastMessage');
        
        // 3. Buat SATU instance toast Bootstrap (ini pakai window.bootstrap dari app.js-mu)
        let toastInstance = null;
        if (window.bootstrap && window.bootstrap.Toast) {
             toastInstance = new window.bootstrap.Toast(toastEl);
        } else {
            console.error('Bootstrap Toast library not found. Toast tidak akan berfungsi.');
            return;
        }

        // 4. Buat fungsi "pintar" untuk menampilkan toast
        const showToast = (type, message) => {
            if (!toastInstance) return;

            // Set pesan
            messageEl.innerText = message;
            
            // Hapus class warna lama
            headerEl.classList.remove('text-bg-success', 'text-bg-danger', 'text-bg-warning', 'text-bg-info');
            
            // Atur warna, ikon, dan judul baru
            switch (type) {
                case 'success':
                    titleEl.innerText = 'Sukses';
                    iconEl.className = 'bi bi-check-circle-fill fs-5 me-2';
                    headerEl.classList.add('text-bg-success');
                    break;
                case 'danger':
                case 'error': // Menangani 'error' dari PHP
                    titleEl.innerText = 'Error';
                    iconEl.className = 'bi bi-exclamation-triangle-fill fs-5 me-2';
                    headerEl.classList.add('text-bg-danger');
                    break;
                case 'warning':
                    titleEl.innerText = 'Peringatan';
                    iconEl.className = 'bi bi-exclamation-triangle-fill fs-5 me-2';
                    headerEl.classList.add('text-bg-warning');
                    break;
                case 'info':
                default:
                    titleEl.innerText = 'Info';
                    iconEl.className = 'bi bi-info-circle-fill fs-5 me-2';
                    headerEl.classList.add('text-bg-info');
                    break;
            }
            
            // Tampilkan toast-nya
            toastInstance.show();
        };

        // 5. TRIGGER 1: Dengarkan event dari JavaScript (app.js)
        window.addEventListener('show-toast', (event) => {
            showToast(event.detail.type, event.detail.message);
        });

        // 6. TRIGGER 2: Cek 'flash session' dari PHP saat halaman di-load
        @if (session('success'))
            showToast('success', @json(session('success')));

        {{-- INI DIA TAMBAHANNYA! Kita cek 'status' juga --}}
        @elseif (session('status')) 
            showToast('success', @json(session('status'))); {{-- Anggap 'status' sebagai 'success' --}}

        @elseif (session('error') || $errors->any())
            showToast('danger', @json(session('error') ?? 'Data yang Anda masukkan tidak valid.'));
        @elseif (session('warning'))
            showToast('warning', @json(session('warning')));
        @elseif (session('info'))
            showToast('info', @json(session('info')));
        @endif
    });
</script>