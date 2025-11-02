<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TigaSaudara - @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- Alpine.js (Pindahkan ke head agar siap saat modal diklik) -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}

    <!-- Vite Assets (HANYA Bootstrap) -->
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>

<body class="bg-light">


    <div x-data="{ mode: 'login' }" @load-cart.window="$store.cart.loadCart()" x-init="$store.cart.loadCart()">
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

    <div x-data="{ show: false, message: '', type: 'success' }"
         @show-toast.window="message = $event.detail.message; type = $event.detail.type; show = true; setTimeout(() => show = false, 3000)"
         x-show="show"
         x-transition
         class="position-fixed top-0 end-0 p-3" style="z-index: 9999">
        <div :class="`alert alert-${type} alert-dismissible fade show`" role="alert">
            <span x-text="message"></span>
            <button type="button" class="btn-close" @click="show = false"></button>
        </div>
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
