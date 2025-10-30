@extends('layouts.app')

@section('content')
    <section class="bg-gradient-primary-dark text-white py-5">
        <div class="container">
            <h1 class="display-4">Semua Produk</h1>
            <p class="fs-5 text-white-50">
                Jelajahi koleksi lengkap seafood segar berkualitas premium kami
            </p>
        </div>
    </section>

    <section class="bg-white border-bottom sticky-top shadow-sm" style="top: 81px;">
        <div class="container py-3">
            <form action="{{ route('products.index') }}" method="GET">
                <div class="row g-3 align-items-center">
                    <div class="col-lg-6">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" class="form-control border-0 bg-light" placeholder="Cari produk..." value="{{ request('search') }}">
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <select name="category" class="form-select">
                            <option value="all">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-3 col-6">
                        <select name="sort" class="form-select">
                            <option value="default" {{ request('sort') == 'default' ? 'selected' : '' }}>Urutkan (Default)</option>
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nama (A-Z)</option>
                            <option value="price-asc" {{ request('sort') == 'price-asc' ? 'selected' : '' }}>Harga (Rendah-Tinggi)</option>
                            <option value="price-desc" {{ request('sort') == 'price-desc' ? 'selected' : '' }}>Harga (Tinggi-Rendah)</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="d-none">Apply</button>
            </form>
            {{-- Script untuk auto-submit form saat filter diubah --}}
            <script>
                document.querySelectorAll('.form-control, .form-select').forEach(item => {
                    item.addEventListener('change', () => {
                        item.closest('form').submit();
                    });
                });
            </script>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="mb-3">
                <p class="text-muted">
                    Menampilkan {{ $products->count() }} produk
                </p>
            </div>

            @if($products->isEmpty())
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-fish" style="font-size: 6rem;"></i>
                    <h3 class="mt-3">Produk tidak ditemukan</h3>
                    <p>Coba ubah filter atau kata kunci pencarian Anda</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary mt-2">Reset Filter</a>
                </div>
            @else
                <div class="row g-4">
                    @foreach($products as $product)
                        <div class="col-md-6 col-lg-3">
                            <x-product-card :product="$product" />
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection