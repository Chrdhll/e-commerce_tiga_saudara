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

</body>
</html>
