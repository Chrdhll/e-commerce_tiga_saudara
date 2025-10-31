<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3 Saudara - Fresh. Trust. Simplify.</title>

    <!-- Alpine.js (Pindahkan ke head agar siap saat modal diklik) -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Vite Assets (HANYA Bootstrap) -->
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>

<body class="bg-light">

    {{-- 
      Inisialisasi Alpine untuk state modal. 
      x-data akan diwariskan ke semua child element, 
      termasuk navbar dan modal.
    --}}
    <div x-data="{ mode: 'login' }">
        <!-- Navbar -->
        @include('partials.navbar')

        <!-- Konten Halaman Utama -->
        <main>
            @yield('content')
        </main>

        <!-- Footer -->
        @include('partials.footer')

        <!-- Modal & Offcanvas (Komponen global) -->
        @include('partials.modal-auth')
        @include('partials.offcanvas-cart')
    </div>

    @if (session('show_login_popup'))
        <script>
            // Kita tunggu sampai semua elemen halaman (CSS, gambar, dan file app.js) 
            // selesai di-load
            window.addEventListener('load', (event) => {
                
                // 1. Tentukan ID modal-mu
                // (Ganti 'authModal' dengan ID aslinya dari partials/modal-auth.blade.php)
                const modalId = 'authModal'; 
                const loginModalElement = document.getElementById(modalId);

                if (loginModalElement) {
                    // 2. Ini adalah perintah JavaScript standar Bootstrap 5
                    // untuk membuat instance modal dan menampilkannya.
                    const modal = new bootstrap.Modal(loginModalElement);
                    modal.show();
                } else {
                    console.error('Modal dengan ID "' + modalId + '" tidak ditemukan.');
                }

            });
        </script>
    @endif
</body>

</html>
