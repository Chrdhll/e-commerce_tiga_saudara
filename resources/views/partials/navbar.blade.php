<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top py-3">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand" href="{{ route('home') }}">
            {{-- Pastikan Anda menaruh logo.png di folder `public/images/` --}}
            <img src="{{ asset('images/foooter.png') }}" alt="Tiga Saudara Logo" style="height: 3.5rem;">
        </a>

        <!-- Tombol Toggle (Mobile) -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
            aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Link Navigasi -->
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0" style="gap: 1rem;">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                        href="{{ route('home') }}">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('products.index') ? 'active' : '' }}"
                        href="{{ route('products.index') }}">Produk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('categories.index') ? 'active' : '' }}"
                        href="{{ route('categories.index') }}">Kategori</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}"
                        href="{{ route('about') }}">Tentang Kami</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}"
                        href="{{ route('contact') }}">Kontak</a>
                </li>
            </ul>

            <!-- Aksi (Search, Auth, Cart) -->
            <div class="d-flex align-items-center">
                <button class="btn btn-link text-dark d-none d-lg-inline-block">
                    {{-- <i class="bi bi-search fs-5"></i> --}}
                </button>

                <!-- Tombol Auth (DINAMIS) -->
                @guest
                    <!-- Jika User Tamu (Belum Login) -->
                    <div class="d-none d-lg-flex align-items-center" style="gap: 0.5rem;">
                        <button class="btn btn-link text-primary" data-bs-toggle="modal" data-bs-target="#authModal"
                            @click="mode = 'login'">
                            Masuk
                        </button>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#authModal"
                            @click="mode = 'register'">
                            Daftar
                        </button>
                    </div>
                @endguest

                @auth
                    <!-- Jika User Sudah Login -->
                    <div class="d-none d-lg-flex align-items-center">
                        <div class="dropdown">
                            <button class="btn btn-link text-dark dropdown-toggle" type="button" id="userMenu"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle fs-5 me-1 text-primary"></i>
                                {{ Auth::user()->name }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profil</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <!-- Tombol Logout -->
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                @endauth

                <!-- Tombol Keranjang -->
                @php
                    $cartItemsCount = \Cart::count();
                @endphp
                <button class="btn btn-outline-primary ms-2 position-relative" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#cartDrawer" aria-controls="cartDrawer">
                    <i class="bi bi-cart fs-5"></i>

                    {{-- Badge ini sekarang dikontrol oleh Alpine.js --}}
                    <span x-show="$store.cart.count > 0" x-cloak
                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        <span x-text="$store.cart.count"></span>
                        <span class="visually-hidden">items in cart</span>
                    </span>
                </button>

                <!-- Tombol Menu (Mobile only) -->
                @guest
                    <button class="btn btn-link text-dark d-lg-none ms-1" data-bs-toggle="modal" data-bs-target="#authModal"
                        @click="mode = 'login'">
                        <i class="bi bi-person-fill fs-5"></i>
                    </button>
                @endguest
            </div>
        </div>
    </div>
</nav>
