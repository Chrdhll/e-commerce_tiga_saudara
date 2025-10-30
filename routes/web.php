<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Auth\GoogleLoginController;

/*
|--------------------------------------------------------------------------
| Rute Storefront (Publik) - Menggunakan Bootstrap
|--------------------------------------------------------------------------
| Ini adalah rute untuk pengunjung.
*/
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/tentang-kami', [PageController::class, 'about'])->name('about');
Route::get('/kontak', [PageController::class, 'contact'])->name('contact');
Route::get('/produk', [ProductController::class, 'index'])->name('products.index');
Route::get('/kategori', [CategoryController::class, 'index'])->name('categories.index');
// Nanti tambahkan: Route::get('/kategori/{slug}', [CategoryController::class, 'show'])->name('categories.show');

/*
|--------------------------------------------------------------------------
| Rute Autentikasi (Breeze & Google) - Menggunakan Tailwind
|--------------------------------------------------------------------------
| Rute-rute ini (dari auth.php) akan menggunakan layouts/guest.blade.php
*/
require __DIR__.'/auth.php';

Route::get('/auth/google/redirect', [GoogleLoginController::class, 'redirectToGoogle'])
        ->name('google.login');
Route::get('/auth/google/callback', [GoogleLoginController::class, 'handleGoogleCallback']);

/*
|--------------------------------------------------------------------------
| Rute Internal (Dashboard & Profil) - Menggunakan Tailwind
|--------------------------------------------------------------------------
| Halaman untuk pengguna yang sudah login.
*/
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        // Arahkan ke Filament jika admin, atau ke dashboard biasa
        // if (auth()->user()->isAdmin()) {
        //     return redirect('/admin');
        // }
        return view('dashboard');
    })->middleware(['verified'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rute Keranjang (Contoh)
// Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
// ...
