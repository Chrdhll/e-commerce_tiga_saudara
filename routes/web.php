<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Auth\GoogleLoginController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

use App\Models\Category;
use App\Models\Product;
use App\Models\Page;


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
Route::get('/produk/{product:slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/kategori', [CategoryController::class, 'index'])->name('categories.index');
// Nanti tambahkan: Route::get('/kategori/{slug}', [CategoryController::class, 'show'])->name('categories.show');

/*
|--------------------------------------------------------------------------
| Rute Autentikasi (Breeze & Google) - Menggunakan Tailwind
|--------------------------------------------------------------------------
| Rute-rute ini (dari auth.php) akan menggunakan layouts/guest.blade.php
*/
require __DIR__ . '/auth.php';

Route::post('/admin/logout', [AuthenticatedSessionController::class, 'destroy'])
         ->middleware('auth')
         ->name('filament.admin.auth.logout');

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
        $orders = Auth::user()->orders()
                            ->with('items.product') // Ambil juga item & info produknya
                            ->latest()
                            ->paginate(10); // Tampilkan 10 pesanan per halaman

        // Kirim data $orders ke view 'dashboard'
        return view('dashboard', compact('orders'));
    })->middleware(['verified'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth', 'verified'])->prefix('cart')->group(function () {

    Route::post('/add', [CartController::class, 'add'])->name('cart.add');

    Route::post('/update/{rowId}', [CartController::class, 'update'])->name('cart.update');
    Route::get('/remove/{rowId}', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/clear', [CartController::class, 'clear'])->name('cart.clear');
});

Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout')->middleware('auth', 'verified');
Route::post('/order/now', [CartController::class, 'orderNow'])->name('order.now')->middleware('auth', 'verified');
Route::get('/cart/content', [CartController::class, 'content'])->name('cart.content');  
