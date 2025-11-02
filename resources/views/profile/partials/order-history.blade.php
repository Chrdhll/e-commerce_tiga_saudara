<div class="card-header bg-white py-3">
    <h5 class="mb-0 text-primary">Riwayat Pembelian</h5>
    <p class="small text-muted mb-0">Daftar semua transaksi Anda.</p>
</div>
<div class="card-body p-4">
    @if($orders->isEmpty())
        <p class="text-muted text-center">Anda belum memiliki riwayat pembelian.</p>
    @else
        <div class="accordion" id="orderHistoryAccordion">
            @foreach($orders as $order)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading-{{ $order->id }}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $order->id }}" aria-expanded="false" aria-controls="collapse-{{ $order->id }}">
                            <div class="d-flex flex-wrap justify-content-between w-100 me-2" style="gap: 10px;">
                                <div class="fw-bold">Invoice: {{ $order->invoice_number }}</div>
                                <div class="text-muted small">{{ $order->created_at->format('d M Y') }}</div>
                                
                                {{-- Gunakan status dari Filament Anda --}}
                                <div>
                                    <span class="badge {{ 
                                        match(strtolower($order->status)) {
                                            'completed' => 'bg-success',
                                            'processing', 'shipped' => 'bg-info',
                                            'cancelled' => 'bg-danger',
                                            default => 'bg-warning'
                                        } 
                                    }}">{{ Str::title($order->status) }}</span>
                                    
                                    <span class="badge {{ 
                                        match(strtolower($order->payment_status)) {
                                            'paid' => 'bg-success',
                                            default => 'bg-warning'
                                        } 
                                    }}">{{ Str::title($order->payment_status) }}</span>
                                </div>
                            </div>
                        </button>
                    </h2>
                    <div id="collapse-{{ $order->id }}" class="accordion-collapse collapse" aria-labelledby="heading-{{ $order->id }}" data-bs-parent="#orderHistoryAccordion">
                        <div class="accordion-body">
                            <ul class="list-group list-group-flush">
                                @foreach($order->items as $item)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        {{-- Ambil nama dari relasi product, karena tidak ada di 'order_items' --}}
                                        <div class="fw-bold">{{ $item->product->name ?? 'Produk Dihapus' }}</div>
                                        <small class="text-muted">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</small>
                                    </div>
                                    <div class="fw-bold">Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</div>
                                </li>
                                @endforeach
                                <li class="list-group-item d-flex justify-content-between align-items-center bg-light">
                                    <div class="fw-bold fs-5">Total Pesanan</div>
                                    {{-- Gunakan 'total_price' dari 'orders' --}}
                                    <div class="fw-bold fs-5 text-primary">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
                                </li>
                            </ul>
                            <div class="mt-3">
                                <h6 class="text-muted">Alamat Pengiriman:</h6>
                                <p class="mb-0">{{ $order->shipping_address }}</p>
                                <p class="mb-0">{{ $order->phone_number }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Link Paginasi -->
        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    @endif
</div>
