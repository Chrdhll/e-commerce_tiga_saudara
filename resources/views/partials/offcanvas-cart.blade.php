<div class="offcanvas offcanvas-end" tabindex="-1" id="cartDrawer" aria-labelledby="cartDrawerLabel" style="width: 100%; max-width: 450px;">
    
    <div class="offcanvas-header bg-primary text-white">
        <h5 class="offcanvas-title d-flex align-items-center" id="cartDrawerLabel">
            <i class="bi bi-cart fs-4 me-2"></i>
            Keranjang Belanja
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    
    <div class="offcanvas-body p-0 d-flex flex-column">
        @php
            // DIUBAH: Ambil data asli dari package Cart
            $cartItems = \Cart::content();
            $subtotal = \Cart::subtotal(0, ',', '.'); // 0 desimal, ',' pemisah ribuan, '.' pemisah desimal
        @endphp

        @if($cartItems->isEmpty())
            <div class="d-flex flex-column align-items-center justify-content-center h-100 text-center text-muted p-4">
                <i class="bi bi-bag-x" style="font-size: 6rem;"></i>
                <p class="fs-5 mt-3">Keranjang belanja kosong</p>
                <p class="text-sm">Mulai belanja sekarang!</p>
            </div>
        @else
            <div class="flex-grow-1 overflow-auto p-3">
                @foreach($cartItems as $item)
                    <div class="d-flex gap-3 bg-white p-3 rounded shadow-sm mb-3">
                        <img src="{{ Storage::url($item->options->image) }}" alt="{{ $item->name }}" class="rounded" style="width: 80px; height: 80px; object-fit: cover;">
                        
                        <div class="flex-grow-1">
                            <h6 class="mb-1 text-truncate">{{ $item->name }}</h6>
                            <p class="text-primary mb-2">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                            
                            <form action="{{ route('cart.update', $item->rowId) }}" method="POST" class="d-flex align-items-center">
                                @csrf
                                <button type="submit" name="action" value="decrease" class="btn btn-outline-secondary btn-sm" style="width: 30px; height: 30px;">-</button>
                                <input type="text" class="form-control form-control-sm text-center border-0" value="{{ $item->qty }}" readonly style="width: 40px; height: 30px; margin: 0 5px;">
                                <button type="submit" name="action" value="increase" class="btn btn-outline-secondary btn-sm" style="width: 30px; height: 30px;">+</button>
                            </form>
                        </div>
                        <div class="d-flex flex-column justify-content-between align-items-end">
                            <a href="{{ route('cart.remove', $item->rowId) }}" class="btn btn-link text-danger p-0" title="Hapus item">
                                <i class="bi bi-trash-fill"></i>
                            </a>
                            <p class="text-primary mb-0 fw-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="border-top p-3 bg-light">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="fs-5">Subtotal:</span>
                    <span class="fs-4 text-primary fw-bold">Rp {{ $subtotal }}</span>
                </div>
                
                {{-- Buat pesan WA --}}
                @php
                    $waMessage = "Halo 3 Saudara! Saya ingin memesan:\n\n";
                    foreach($cartItems as $item) {
                        $waMessage .= "{$item->name} - {$item->qty} {$item->options->unit} (Rp " . number_format($item->subtotal, 0, ',', '.') . ")\n";
                    }
                    $waMessage .= "\nTotal: Rp {$subtotal}";
                @endphp
                
                <a href="https://wa.me/6283189865216?text={{ urlencode($waMessage) }}" target="_blank" class="btn w-100 fs-6 py-2" style="background-color: #25D366; color: white;">
                    <i class="bi bi-whatsapp me-2"></i>
                    Checkout via WhatsApp
                </a>
                <a href="{{ route('cart.clear') }}" class="btn btn-link text-danger w-100 mt-2">
                    Kosongkan Keranjang
                </a>
            </div>
        @endif
    </div>
</div>