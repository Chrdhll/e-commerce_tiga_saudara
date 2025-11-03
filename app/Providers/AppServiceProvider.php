<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View; 
use App\Models\Category;

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
    }
}
