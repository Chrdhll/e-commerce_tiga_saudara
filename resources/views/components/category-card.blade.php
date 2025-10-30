@props(['category'])

<div class="card text-white card-category border-0 shadow-lg" style="overflow: hidden;">
    {{-- DIUBAH: $category->imageUrl menjadi $category->image --}}
    <img src="{{ Storage::url($category->image) }}" class="card-img" alt="{{ $category->name }}" style="height: 250px; object-fit: cover; transition: transform 0.3s ease;">
    <div class="card-img-overlay d-flex flex-column justify-content-end" style="background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);">
        <h3 class="card-title fs-4">{{ $category->name }}</h3>
        {{-- 'products_count' akan ada jika Anda menggunakan 'withCount()' di controller --}}
        <p class="card-text">{{ $category->products_count ?? 0 }} Produk</p>
    </div>
    <span class="badge bg-secondary position-absolute top-0 end-0 m-3">
        Lihat
    </span>
    <a href="#" class="stretched-link"></a> {{-- Ganti # dengan route('categories.show', $category->slug) --}}
</div>