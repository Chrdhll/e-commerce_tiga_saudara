<footer class="bg-gradient-primary-dark text-white pt-5 pb-4">
    <div class="container text-white-50">
        <div class="row gy-4 mb-4">
            
            <div class="col-lg-4 col-md-6">
                <img src="/images/foooter.png" alt="3 Saudara Logo" class="mb-3"
                    style="width: 15rem; height: auto; filter: brightness(0) invert(1);">
                <p class="mb-3">Menyediakan seafood segar berkualitas tinggi untuk keluarga Indonesia.</p>
                <div class="d-flex" style="gap: 0.75rem;">
                    
                    {{-- Mengambil data dari Settings --}}
                    {{-- Kita pakai '?? #' jika datanya tidak ada --}}
                    <a href="{{ $settings['social_facebook']->value ?? '#' }}" target="_blank" class="text-white-50 link-light fs-5">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="{{ $settings['social_instagram']->value ?? '#' }}" target="_blank" class="text-white-50 link-light fs-5">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="{{ $settings['social_whatsapp']->value ?? '#' }}" target="_blank" class="text-white-50 link-light fs-5">
                        <i class="bi bi-whatsapp"></i>
                    </a>
                    
                </div>
            </div>

            <div class="col-lg-2 col-md-6">
                <h5 class="text-white mb-3">Menu Cepat</h5>
                <ul class="list-unstyled d-flex flex-column" style="gap: 0.5rem;">
                    <li><a href="{{ route('home') }}" class="text-white-50 link-light text-decoration-none">Beranda</a></li>
                    <li><a href="{{ route('products.index') }}" class="text-white-50 link-light text-decoration-none">Produk</a></li>
                    <li><a href="{{ route('categories.index') }}" class="text-white-50 link-light text-decoration-none">Kategori</a></li>
                    <li><a href="{{ route('about') }}" class="text-white-50 link-light text-decoration-none">Tentang Kami</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6">
                <h5 class="text-white mb-3">Kategori Populer</h5>

                @if (isset($footerCategories) && $footerCategories->count() > 0)
                    <ul class="list-unstyled d-flex flex-column" style="gap: 0.5rem;">
                        @foreach ($footerCategories as $category)
                            <li>
                                <a href="{{ route('products.index', ['category' => $category->id]) }}"
                                    class="text-white-50 link-light text-decoration-none">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <ul class="list-unstyled d-flex flex-column" style="gap: 0.5rem;">
                        <li><a href="{{ route('products.index') }}"
                                class="text-white-50 link-light text-decoration-none">Semua Produk</a></li>
                    </ul>
                @endif
            </div>

            <div class="col-lg-3 col-md-6">
                <h5 class="text-white mb-3">Kontak Kami</h5>
                <ul class="list-unstyled d-flex flex-column" style="gap: 0.75rem;">
                    <li class="d-flex align-items-start">
                        <i class="bi bi-geo-alt-fill fs-5 me-2" style="margin-top: 3px;"></i>
                        {{-- Mengambil data dari Settings --}}
                        <span>{{ $settings['contact_address']->value ?? 'Alamat belum diatur' }}</span>
                    </li>
                    <li class="d-flex align-items-center">
                        <i class="bi bi-telephone-fill fs-5 me-2"></i>
                        <span>{{ $settings['contact_phone']->value ?? 'Telepon belum diatur' }}</span>
                    </li>
                    <li class="d-flex align-items-center">
                        <i class="bi bi-envelope-fill fs-5 me-2"></i>
                        <span>{{ $settings['contact_email']->value ?? 'Email belum diatur' }}</span>
                    </li>
                </ul>
            </div>
        </div>

        <hr class="border-white-50 opacity-25">

        <div class="text-center pt-3">
            {{-- Mengganti tahun statis dengan dinamis --}}
            <p>&copy; {{ date('Y') }} 3 Saudara. All rights reserved. Fresh. Trust. Simplify.</p>
        </div>
    </div>
</footer>