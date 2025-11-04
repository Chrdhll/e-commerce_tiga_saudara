<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use App\Models\Category;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        try {
            View::composer('partials.footer', function ($view) {
                $footerCategories = Category::query()
                                        ->withCount('products') // Hitung jumlah produk
                                        ->orderByDesc('products_count') // Urutkan berdasarkan terpopuler
                                        ->take(4) // Ambil 4 teratas
                                        ->get();

                $view->with('footerCategories', $footerCategories);
            });
        } catch (\Exception $e) {

        }




        View::composer('*', function ($view) {

            // 1. Ambil semua settings dari cache
            // 'all_settings' akan otomatis dibuat ulang jika kosong
            $settings = Cache::rememberForever('all_settings', function () {
                return Setting::all()->keyBy('key');
            });

            // 2. Ambil Kategori Populer (untuk Footer)
            $footerCategories = Cache::remember('footer_categories', now()->addHour(), function () {
                // Mengambil 4 kategori dengan jumlah produk terbanyak
                return Category::withCount('products')
                                ->orderByDesc('products_count')
                                ->limit(4)
                                ->get();
            });

            // 3. Kirim KEDUA variabel ke SEMUA view
            $view->with('settings', $settings)
                 ->with('footerCategories', $footerCategories);
        });


    }
}
