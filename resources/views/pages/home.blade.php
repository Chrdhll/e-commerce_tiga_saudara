@extends('layouts.app')

@section('title', 'Home')

@section('content')
    
    @include('partials.hero')

    <section class="py-5 bg-white">
        <div class="container">
            <div class="row g-4 text-center">
                <div class="col-md-3 col-6">
                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px;">
                        <i class="bi bi-water fs-2 text-primary"></i>
                    </div>
                    <h5 class="h6 mb-2">100% Segar</h5>
                    <p class="text-muted small">Langsung dari laut</p>
                </div>
                <div class="col-md-3 col-6">
                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px;">
                        <i class="bi bi-award fs-2 text-secondary"></i>
                    </div>
                    <h5 class="h6 mb-2">Kualitas Terjamin</h5>
                    <p class="text-muted small">Produk berkualitas premium</p>
                </div>
                <div class="col-md-3 col-6">
                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px;">
                        <i class="bi bi-truck fs-2 text-primary"></i>
                    </div>
                    <h5 class="h6 mb-2">Pengiriman Cepat</h5>
                    <p class="text-muted small">Diantar fresh dalam 24 jam</p>
                </div>
                <div class="col-md-3 col-6">
                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px;">
                        <i class="bi bi-shield-check fs-2 text-secondary"></i>
                    </div>
                    <h5 class="h6 mb-2">Halal & Higienis</h5>
                    <p class="text-muted small">Terjamin kehalalannya</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-4">
                <h2 class="display-5 text-primary">Kategori Produk</h2>
                <p class="text-muted fs-5">Pilih dari berbagai kategori seafood segar pilihan terbaik kami</p>
            </div>
            <div class="row g-4">
                @foreach($categories as $category)
                    <div class="col-md-6 col-lg-4">
                        <x-category-card :category="$category" />
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-4">
                <a href="{{ route('categories.index') }}" class="btn btn-link text-primary text-decoration-none">
                    Lihat Semua Kategori <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

    <section class="py-5 bg-white">
        <div class="container">
            <div class="text-center mb-4">
                <h2 class="display-5 text-primary">Produk Unggulan</h2>
                <p class="text-muted fs-5">Seafood segar pilihan terbaik dengan harga terjangkau</p>
            </div>
            <div class="row g-4">
                @foreach($products as $product)
                    <div class="col-md-6 col-lg-3">
                        <x-product-card :product="$product" />
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-4">
                <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg px-5">
                    Lihat Semua Produk
                </a>
            </div>
        </div>
    </section>

    <section class="py-5 bg-gradient-primary-dark text-white">
        <div class="container text-center">
            <h2 class="display-5 mb-3">Siap Berbelanja Seafood Segar?</h2>
            <p class="fs-5 mb-4 mx-auto text-white-50" style="max-width: 600px;">
                Dapatkan seafood segar berkualitas tinggi dengan harga terbaik. Pesan sekarang!
            </p>
            <div class="d-flex flex-wrap justify-content-center gap-3">
                <a href="{{ route('products.index') }}" class="btn btn-secondary btn-lg px-5">
                    Belanja Sekarang
                </a>
                <a href="{{ route('contact') }}" class="btn btn-outline-light btn-lg px-5">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </section>
@endsection