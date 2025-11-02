@extends('layouts.app')

@section('content')
    <section class="py-5 bg-white">
        {{-- Gunakan Alpine.js untuk melacak kuantitas --}}
        <div class="container" x-data="{ quantity: 1, maxStock: {{ $product->stock }} }">
            <div class="row g-5">
                <div class="col-lg-6">
                    <div class="border rounded-4 shadow-sm p-3">
                        <img src="{{ Storage::url($product->image) }}" class="img-fluid rounded-3" alt="{{ $product->name }}">
                    </div>
                </div>

                <div class="col-lg-6">
                    <span class="badge rounded-pill text-primary border border-primary mb-2">
                        {{ $product->category->name }}
                    </span>

                    <h1 class="display-5 fw-bold">{{ $product->name }}</h1>

                    <div class="mb-3">
                        @if($product->discount)
                            <span class="display-6 text-primary">Rp {{ number_format($product->finalPrice, 0, ',', '.') }}</span>
                            <span class="fs-5 text-muted text-decoration-line-through ms-2">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            <span class="badge bg-danger ms-2">-{{ $product->discount }}%</span>
                        @else
                            <span class="display-6 text-primary">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        @endif
                        <span class="fs-5 text-muted">/ {{ $product->unit }}</span>
                    </div>

                    <div class="mb-3">
                        @if($product->stock > 0)
                            <span class="badge bg-success">Stok Tersedia: {{ $product->stock }}</span>
                        @else
                            <span class="badge bg-danger">Stok Habis</span>
                        @endif
                    </div>

                    <h5 class="mt-4">Deskripsi Produk</h5>
                    <p class="text-muted">{{ $product->description ?? 'Deskripsi produk belum tersedia.' }}</p>

                    <div class="row g-2 mt-4">
                        <div class="col-md-4">
                            <label for="quantity" class="form-label">Kuantitas</label>
                            <div class="input-group">
                                <button class="btn btn-outline-secondary" type="button" @click="quantity = Math.max(1, quantity - 1)" @disabled($product->stock == 0)>-</button>
                                <input type="number" id="quantity" class="form-control text-center" x-model.number="quantity" min="1" :max="maxStock" @disabled($product->stock == 0)>
                                <button class="btn btn-outline-secondary" type="button" @click="quantity = Math.min(maxStock, quantity + 1)" @disabled($product->stock == 0)>+</button>
                            </div>
                        </div>

                        <div class="col-md-8 d-flex align-items-end">
                            {{-- DIUBAH: Ganti <form> dengan <button> --}}
                            <button type="button" class="btn btn-primary btn-lg w-100" 
                                    @click="$store.cart.addItem({{ $product->id }}, quantity)" 
                                    @disabled($product->stock == 0)>
                                <i class="bi bi-cart-plus me-2"></i>
                                Tambah ke Keranjang
                            </button>
                        </div>

                        <div class="col-12">
                            <form action="{{ route('order.now') }}" method="POST" class="w-100">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" x-model="quantity">
                                <button type="submit" class="btn btn-secondary btn-lg w-100" @disabled($product->stock == 0)>
                                    <i class="bi bi-whatsapp me-2"></i>
                                    Pesan Sekarang
                                </button>
                            </form>
                        </div>
                        <div class="col-12">
                            <small class="text-muted text-center d-block">Tombol "Pesan Sekarang" akan langsung membuat pesanan dan mengarahkan Anda ke WhatsApp.</small>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    @if($relatedProducts->count() > 0)
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="mb-4 text-primary">Produk Terkait</h2>
            <div class="row g-4">
                @foreach($relatedProducts as $relatedProduct)
                    <div class="col-md-6 col-lg-3">
                        <x-product-card :product="$relatedProduct" />
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
@endsection