# E-Commerce Tiga Saudara

> Aplikasi e-commerce (Toko Online) "Tiga Saudara", sebuah platform penjualan seafood yang dibangun menggunakan Laravel 12.

Aplikasi ini memiliki storefront (halaman toko) yang responsif untuk pelanggan, dan panel admin yang *powerful* (Filament) untuk manajemen toko. Fitur unik dari aplikasi ini adalah sistem checkout "semi-manual" yang terintegrasi langsung dengan WhatsApp, di mana pesanan akan tercatat di database terlebih dahulu sebelum dikonfirmasi melalui chat.

---

## 🚀 Fitur Utama

### 🛍️ Storefront (Bootstrap 5)
* Halaman Beranda dengan Hero Section dan daftar produk/kategori.
* Halaman Produk dengan fitur pencarian dan filter berdasarkan kategori (slug).
* Halaman Detail Produk dengan galeri, deskripsi, dan produk terkait.
* Halaman Kategori untuk menjelajahi produk.
* Halaman Kontak dengan Peta Lokasi dan Saluran Bantuan.

### 🛒 Keranjang Belanja (AJAX)
* Tambah/Update/Hapus item keranjang tanpa *reload* halaman (menggunakan Alpine.js & Axios).
* Ikon keranjang di navbar dengan *badge* jumlah item yang *real-time*.

### 📲 Sistem Checkout (WhatsApp)
* Tombol "Tambah ke Keranjang" (AJAX).
* Tombol "Pesan Sekarang" (Bypass keranjang, langsung ke WA).
* Saat checkout, data pesanan (Orders & OrderItems) disimpan ke database dengan status "Pending".
* Pelanggan secara otomatis diarahkan ke WhatsApp dengan pesan yang sudah terisi (termasuk Invoice Number) untuk konfirmasi pembayaran.

### 👤 Manajemen Pengguna (Laravel Breeze)
* Sistem registrasi dan login pelanggan (termasuk login via Google).
* Halaman Dashboard Pelanggan untuk melihat Riwayat Pembelian.
* Halaman Profil untuk mengubah Nama, Email, Password, Alamat, dan Nomor Telepon.

### ⚙️ Panel Admin (Filament 3)
* Panel admin di `/admin` untuk manajemen Toko.
* Manajemen Produk, Kategori, dan Pesanan.
* Admin dapat melihat pesanan baru yang masuk dan mengubah status serta *payment\_status* (misal, dari "Pending" menjadi "Selesai").

---

## 🛠️ Tumpukan Teknologi (Tech Stack)

Aplikasi ini menggunakan pendekatan *hybrid* untuk *styling* agar dapat mengintegrasikan *framework* yang berbeda.

* **Backend:** PHP 8.4+, Laravel 12, MySQL
* **Panel Admin:** Filament 3 (menggunakan Tailwind CSS)
* **Autentikasi:** Laravel Breeze (menggunakan Tailwind CSS)
* **Storefront (Halaman Toko):** Bootstrap 5.3 & Sass (SCSS)
* **Frontend Interactivity:** Alpine.js (untuk keranjang) & Axios (untuk AJAX)
* **Bundler:** Vite
* **PHP Packages:** `hardevine/shoppingcart` (untuk logika keranjang belanja)

---

