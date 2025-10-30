<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class PageController extends Controller
{
    /**
     * Menampilkan halaman beranda (home).
     */
    public function home()
    {
        // 1. AMBIL PRODUK
        // Karena model Anda tidak punya 'is_featured',
        // kita ambil saja 4 produk terbaru sebagai "Produk Unggulan".
        $products = Product::with('category') // Eager load relasi
                            ->latest()         // Ambil yang terbaru
                            ->take(4)          // Batasi 4 produk
                            ->get();
        
        // 2. AMBIL KATEGORI
        $categories = Category::withCount('products')->take(6)->get();

        // 3. KIRIM DATA KE VIEW
        // Error Anda terjadi di sini. Sekarang $products sudah ada.
        return view('pages.home', compact('products', 'categories'));
    }

    /**
     * Menampilkan halaman "Tentang Kami".
     */
    public function about()
    {
        // Kode ini dari file 'AboutPage.tsx'
        return view('pages.about');
    }

    /**
     * Menampilkan halaman "Kontak".
     */
    public function contact()
    {
        // Kode ini dari file 'ContactPage.tsx'
        return view('pages.contact');
    }
}