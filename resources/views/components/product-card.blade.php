@props(['product'])

<div class="card h-100 card-product border-0 shadow-sm">
    <div class="position-relative overflow-hidden">
        {{-- DIUBAH: Gambar sekarang menjadi link --}}
        <a href="{{ route('products.show', $product->slug) }}">
            <img src="{{ Storage::url($product->image) }}" class="card-img-top" alt="{{ $product->name }}"
                style="height: 220px; object-fit: cover;">
        </a>

        @if ($product->discount)
            <span class="badge bg-danger position-absolute top-0 start-0 m-2">
                -{{ $product->discount }}%
            </span>
        @endif

        @if ($product->stock < 10 && $product->stock > 0)
            <span class="badge bg-secondary position-absolute bottom-0 start-0 m-2">
                Stok Terbatas
            </span>
        @endif

        {{-- <button class="btn btn-light btn-sm position-absolute top-0 end-0 m-2 rounded-circle" style="width: 32px; height: 32px;">
            <i class="bi bi-heart text-muted"></i>
        </button> --}}
    </div>

    <div class="card-body p-4 d-flex flex-column">
        <div>
            <span class="badge rounded-pill text-primary border border-primary mb-2">
                {{ $product->category->name }}
            </span>

            {{-- DIUBAH: Nama produk sekarang menjadi link --}}
            <h5 class="card-title h6 mb-2" style="min-height: 3rem;">
                <a href="{{ route('products.show', $product->slug) }}"
                    class="text-dark text-decoration-none stretched-link">
                    {{ $product->name }}
                </a>
            </h5>
        </div>

        <div class="mt-auto">
            <div class="mb-3" style="min-height: 2.5rem;">
                @if ($product->discount)
                    <span class="fs-5 text-primary">Rp {{ number_format($product->finalPrice, 0, ',', '.') }}</span>
                    <span class="text-muted text-decoration-line-through small ms-2">Rp
                        {{ number_format($product->price, 0, ',', '.') }}</span>
                @else
                    <span class="fs-5 text-primary">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                @endif
                <span class="text-muted small">/ kg</span>
            </div>

            <div class="position-relative" style="z-index: 2;">
                @auth
                    {{-- User sudah login --}}

                    @if (!auth()->user()->is_admin)
                        {{-- 1. Tombol untuk PELANGGAN (bukan admin) --}}
                        <button type="button"     class="btn btn-primary w-100"
                            @click="$store.cart.addItem({{ $product->id }})"
                            @disabled($product->stock == 0)>
                            <i class="bi bi-cart-plus me-2"></i>
                            {{ $product->stock == 0 ? 'Stok Habis' : 'Tambah ke Keranjang' }}
                            </button>
                    @else
                        {{-- 2. Tombol disabled untuk ADMIN --}}
                        <button type="button" class="btn btn-secondary w-100"
                            disabled title="Admin tidak bisa berbelanja">
                            <i class="bi bi-person-badge me-2"></i>
                            Admin Mode
                            </button>
                    @endif
                    
                @endauth

                @guest
                    {{-- 3. Tombol untuk GUEST (belum login) --}}
                    {{-- Ini akan memicu pop-up login-mu --}}
                    <button type="button" class="btn btn-primary w-100"
                        {{-- GANTI 'authModal' dengan ID modal login-mu --}}
                        onclick="new bootstrap.Modal(document.getElementById('authModal')).show()">
                        <i class="bi bi-box-arrow-in-right me-2"></i>
                        Login untuk Membeli
                        </button>
                @endguest
            </div>
        </div>
    </div>
</div>
