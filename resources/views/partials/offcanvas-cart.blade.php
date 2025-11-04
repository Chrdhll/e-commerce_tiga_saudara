<div class="offcanvas offcanvas-end" tabindex="-1" id="cartDrawer" aria-labelledby="cartDrawerLabel"
    style="width: 100%; max-width: 450px;">

    <div class="offcanvas-header bg-primary text-white">
        <h5 class="offcanvas-title d-flex align-items-center" id="cartDrawerLabel">
            <i class="bi bi-cart fs-4 me-2"></i>
            Keranjang Belanja
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body p-0 d-flex flex-column">

        <template x-if="$store.cart.count === 0">
            <div class="d-flex flex-column align-items-center justify-content-center h-100 text-center text-muted p-4">
                <i class="bi bi-bag-x" style="font-size: 6rem;"></i>
                <p class="fs-5 mt-3">Keranjang belanja kosong</p>
                <p class="text-sm">Mulai belanja sekarang!</p>
            </div>
        </template>

        <template x-if="$store.cart.count > 0">
            <div class="d-flex flex-column h-100">
                <div class="flex-grow-1 overflow-auto p-3">

                    {{-- Notifikasi Error (jika ada) --}}
                    <div x-data="{ show: false, message: '' }"
                        @show-toast.window="if($event.detail.type === 'danger') { message = $event.detail.message; show = true; setTimeout(() => show = false, 3000) }"
                        x-show="show" x-transition>
                        <div class="alert alert-danger" x-text="message"></div>
                    </div>

                    <template x-for="item in $store.cart.items" :key="item.rowId">
                        <div class="d-flex gap-3 bg-white p-3 rounded shadow-sm mb-3">
                            <img :src="item.options.image_url" :alt="item.name" class="rounded"
                                style="width: 80px; height: 80px; object-fit: cover;">

                            <div class="flex-grow-1">
                                <h6 class="mb-1 text-truncate" x-text="item.name"></h6>
                                <p class="text-primary mb-2" x-text="`Rp ${item.price.toLocaleString('id-ID')}`"></p>

                                <div class="d-flex align-items-center">
                                    <button type="button" class="btn btn-outline-secondary btn-sm"
                                        style="width: 30px; height: 30px;"
                                        @click="$store.cart.updateItem(item.rowId, 'decrease')">-</button>
                                    <input type="text" class="form-control form-control-sm text-center border-0"
                                        :value="item.qty" readonly
                                        style="width: 40px; height: 30px; margin: 0 5px;">
                                    <button type="button" class="btn btn-outline-secondary btn-sm"
                                        style="width: 30px; height: 30px;"
                                        @click="$store.cart.updateItem(item.rowId, 'increase')">+</button>
                                </div>
                            </div>
                            <div class="d-flex flex-column justify-content-between align-items-end">
                                <button type="button" class="btn btn-link text-danger p-0" title="Hapus item"
                                    @click="$store.cart.removeItem(item.rowId)">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                                <p class="text-primary mb-0 fw-bold"
                                    x-text="`Rp ${(item.price * item.qty).toLocaleString('id-ID')}`"></p>
                            </div>
                        </div>
                    </template>
                </div>

                <div class="border-top p-3 bg-light">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="fs-5">Subtotal:</span>
                        <span class="fs-4 text-primary fw-bold" x-text="$store.cart.subtotal"></span>
                    </div>

                    {{-- Cek apakah user sudah login --}}
                    @auth
                        {{-- Jika sudah login, cek apakah dia BUKAN admin --}}
                        @if (!auth()->user()->is_admin)
                            <form action="{{ route('cart.checkout') }}" method="POST" target="_blank">
                                @csrf
                                <button type="submit" class="btn w-100 fs-6 py-2"
                                    style="background-color: #25D366; color: white;">
                                    <i class="bi bi-whatsapp me-2"></i>
                                    Checkout via WhatsApp
                                </button>
                            </form>
                        @endif
                    @endauth

                    {{-- Jika user adalah GUEST (belum login) --}}
                    @guest
                        <button type"button" class="btn btn-primary w-100 fs-6 py-2" data-bs-dismiss="offcanvas"
                            onclick="$store.cart.redirectToLogin()">
                            <i class="bi bi-box-arrow-in-right me-2"></i>
                            Login untuk Checkout
                        </button>
                    @endguest

                    <button type="button" class="btn btn-link text-danger w-100 mt-2" @click="$store.cart.clearCart()">
                        Kosongkan Keranjang
                    </button>
                </div>
            </div>
        </template>
    </div>
</div>
