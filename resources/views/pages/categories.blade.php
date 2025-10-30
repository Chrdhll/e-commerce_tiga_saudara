@extends('layouts.app')

@section('content')
    <section class="bg-gradient-primary-dark text-white py-5">
        <div class="container">
            <h1 class="display-4">Kategori Produk</h1>
            <p class="fs-5 text-white-50">
                Temukan produk seafood berdasarkan kategori pilihan Anda
            </p>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="mb-4">
                <h2 class="display-5 text-primary">Semua Kategori</h2>
                <p class="text-muted fs-5">
                    Pilih kategori untuk melihat produk yang tersedia
                </p>
            </div>

            <div class="row g-4">
                @foreach($categories as $category)
                    <div class="col-md-6 col-lg-4">
                        <x-category-card :category="$category" />
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-5 bg-white">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 text-primary">Kenali Kategori Seafood Kami</h2>
                <p class="text-muted fs-5 mx-auto" style="max-width: 600px;">
                    Setiap kategori dipilih dengan cermat untuk memberikan kualitas terbaik
                </p>
            </div>

            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm p-4 bg-light">
                        <div class="fs-1 mb-3">🐟</div>
                        <h3 class="text-primary">Ikan Segar</h3>
                        <p class="text-muted">
                            Berbagai jenis ikan laut dan air tawar pilihan terbaik. Dari kakap, salmon, hingga gurame.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm p-4" style="background-color: #fff0eb;">
                        <div class="fs-1 mb-3">🦐</div>
                        <h3 class="text-secondary">Udang Premium</h3>
                        <p class="text-muted">
                            Udang segar berbagai ukuran, dari vaname hingga windu. Tekstur kenyal dan rasa manis alami.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm p-4 bg-light">
                        <div class="fs-1 mb-3">🦀</div>
                        <h3 class="text-primary">Kepiting & Rajungan</h3>
                        <p class="text-muted">
                            Kepiting segar dengan daging lembut dan lezat. Pilihan favorit untuk sajian istimewa.
                        </p>
                    </div>
                </div>
                </div>
        </div>
    </section>
@endsection