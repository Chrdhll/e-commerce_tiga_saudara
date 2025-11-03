// 1. Impor Bootstrap JS (termasuk Popper)
import "~bootstrap/dist/js/bootstrap.bundle.min.js";

// 2. Impor Axios (diambil dari bootstrap.js Laravel)
import axios from "axios";
window.axios = axios;
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

// 3. Impor Alpine
import Alpine from "alpinejs";

// 4. Definisikan Store Keranjang
Alpine.store("cart", {
    items: {},
    count: 0,
    subtotal: "Rp 0",

    async loadCart() {
        try {
            const response = await axios.get("/cart/content");
            this.items = response.data.items;
            this.count = response.data.count;
            this.subtotal = response.data.subtotal;
        } catch (error) {
            console.error("Gagal memuat keranjang:", error);
            // Non-aktifkan toast error saat load agar tidak mengganggu
            // this.toast('Gagal memuat keranjang', 'danger');
        }
    },

    async addItem(productId, quantity = 1) {
        try {
            // Ambil CSRF token dari <meta> tag
            const token = document.head.querySelector(
                'meta[name="csrf-token"]'
            ).content;

            await axios.post("/cart/add", {
                product_id: productId,
                quantity: quantity,
                _token: token,
            });
            await this.loadCart();
            this.toast("Produk ditambahkan ke keranjang", "success");

            // Buka offcanvas secara otomatis
            // Pastikan 'bootstrap' ada di scope global
            new bootstrap.Offcanvas(
                document.getElementById("cartDrawer")
            ).show();
        } catch (error) {
            console.error("Gagal menambah item:", error.response);

            if (error.response && error.response.status === 401) {
                const loginModal = new window.bootstrap.Modal(
                    document.getElementById("authModal")
                );
                loginModal.show();
                this.toast("Silakan login untuk melanjutkan", "info");
            } else if (error.response && error.response.status === 403) {
                // 409 = BELUM VERIFIKASI (dari middleware 'verified')
                // INI ADALAH SOLUSIMU
                this.toast(
                    "Anda harus verifikasi email terlebih dahulu",
                    "warning"
                );

                // Redirect paksa ke halaman verifikasi email
                window.location.href = "/verify-email";
            } else if (error.response && error.response.status === 403) {
                // 403 = ADMIN (dari CartController)
                this.toast(
                    error.response.data.message ||
                        "Admin tidak boleh berbelanja",
                    "danger"
                );
            } else if (error.response && error.response.status === 422) {
                // 422 = STOK HABIS (dari CartController)
                this.toast(
                    error.response.data.message || "Stok tidak mencukupi",
                    "danger"
                );
            } else {
                // Error lainnya
                this.toast("Gagal menambah item", "danger");
            }
        }
    },

    async updateItem(rowId, action) {
        try {
            const token = document.head.querySelector(
                'meta[name="csrf-token"]'
            ).content;
            await axios.post(`/cart/update/${rowId}`, {
                action: action,
                _token: token,
            });
            await this.loadCart();
        } catch (error) {
            console.error("Gagal update item:", error);
            this.toast(
                error.response?.data?.message || "Gagal update item",
                "danger"
            );
        }
    },

    async removeItem(rowId) {
        try {
            await axios.get(`/cart/remove/${rowId}`);
            await this.loadCart();
            this.toast("Produk dihapus dari keranjang", "warning");
        } catch (error) {
            console.error("Gagal hapus item:", error);
            this.toast("Gagal hapus item", "danger");
        }
    },

    async clearCart() {
        try {
            await axios.get("/cart/clear");
            await this.loadCart();
            this.toast("Keranjang dikosongkan", "info");
        } catch (error) {
            console.error("Gagal mengosongkan keranjang:", error);
            this.toast("Gagal mengosongkan keranjang", "danger");
        }
    },

    toast(message, type = "success") {
        window.dispatchEvent(
            new CustomEvent("show-toast", { detail: { message, type } })
        );
    },
});

// 5. Mulai Alpine
window.Alpine = Alpine;
Alpine.start();
