<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top py-3">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand" href="{{ route('home') }}">
            {{-- Pastikan Anda menaruh logo.png di folder `public/images/` --}}
            
            <!-- Logo Desktop (3.5rem) -->
            <img src="{{ asset('images/foooter.png') }}" alt="Tiga Saudara Logo" class="d-none d-lg-inline-block" style="height: 3.5rem;">
            <!-- Logo Mobile (lebih kecil, 2.5rem) -->
            <img src="{{ asset('images/foooter.png') }}" alt="Tiga Saudara Logo" class="d-lg-none" style="height: 2.5rem;">
        </a>

      
        
        <!-- Aksi Mobile: Tombol Keranjang & Tombol Toggler -->
        <div class="d-flex align-items-center d-lg-none">
            
            <!-- Tombol Keranjang (Mobile) - Margin diubah ke me-1 -->
            <button class="btn btn-outline-primary me-1 position-relative" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#cartDrawer" aria-controls="cartDrawer">
                <i class="bi bi-cart fs-5"></i>
                <span x-show="$store.cart.count > 0" x-cloak
                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    <span x-text="$store.cart.count"></span>
                    <span class="visually-hidden">items in cart</span>
                </span>
            </button>
            
            <!-- Tombol Toggle (Mobile) - Padding diubah ke px-1 -->
            <button class="navbar-toggler px-1" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
                aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>

       


        <!-- Link Navigasi & Aksi Desktop -->
        <div class="collapse navbar-collapse" id="mainNavbar">
            
            <!-- Link Navigasi (Center) -->
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0 text-nowrap" style="gap: 1rem;">
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

           

            <!-- Aksi (Search, Auth, Cart) - HANYA DESKTOP -->
            <div class="d-none d-lg-flex align-items-center">
                <button class="btn btn-link text-dark">
                    {{-- <i class="bi bi-search fs-5"></i> --}}
                </button>

                <!-- Tombol Auth (DINAMIS) -->
                @guest
                    <!-- Jika User Tamu (Belum Login) -->
                    <div class="d-flex align-items-center" style="gap: 0.5rem;">
                        <button class="btn text-primary" data-bs-toggle="modal" data-bs-target="#authModal"
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
                    <div class="dropdown">
                        <button class="btn btn-link text-dark dropdown-toggle" type="button" id="userMenu"
                            data-bs-toggle="dropdown" aria-expanded="false"
                            style="text-decoration: none;">
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
                @endauth

                <!-- Tombol Keranjang (Desktop) -->
                <button class="btn btn-outline-primary ms-2 position-relative" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#cartDrawer" aria-controls="cartDrawer">
                    <i class="bi bi-cart fs-5"></i>
                    <span x-show="$store.cart.count > 0" x-cloak
                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        <span x-text="$store.cart.count"></span>
                        <span class="visually-hidden">items in cart</span>
                    </span>
                </button>
            </div>

            <!-- Tombol Auth & Logout (HANYA MOBILE) -->
            <div class="d-lg-none border-top mt-3 pt-3">
                @guest
                    <a class="btn btn-outline-primary w-100 mb-2" data-bs-toggle="modal" data-bs-target="#authModal" @click="mode = 'login'">
                        Masuk
                    </a>
                    <a class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#authModal" @click="mode = 'register'">
                        Daftar
                    </a>
                @endguest

                @auth
                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-person-circle fs-4 me-2 text-primary"></i>
                        <span class="fw-bold">{{ Auth::user()->name }}</span>
                    </div>
                    <ul class="list-unstyled">
                        <li><a class="dropdown-item py-2" href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li><a class="dropdown-item py-2" href="{{ route('profile.edit') }}">Profil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger py-2">Logout</button>
                            </form>
                        </li>
                    </ul>
                @endauth
            </div>
        </div>
    </div>
</nav>