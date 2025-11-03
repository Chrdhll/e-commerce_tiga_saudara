@props(['category'])

{{-- Ubah <div> terluar menjadi <a> --}}
<a href="{{ route('products.index', ['category' => $category->id]) }}" 
   class="card text-white card-category border-0 shadow-lg text-decoration-none" 
   style="overflow: hidden;">
    
    <img src="{{ Storage::url($category->image) }}" class="card-img" alt="{{ $category->name }}" style="height: 250px; object-fit: cover; transition: transform 0.3s ease;">
    
    <div class="card-img-overlay d-flex flex-column justify-content-end" style="background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);">
        <h3 class="card-title fs-4">{{ $category->name }}</h3>
        <p class="card-text">{{ $category->products_count ?? 0 }} Produk</p>
    </div>
    
    <span class="badge bg-secondary position-absolute top-0 end-0 m-3">
        Lihat
    </span>
    
    {{-- Hapus <a href="#" class="stretched-link"></a> --}}
</a>