<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;

class StatsOverview extends BaseWidget
{
    // Atur urutan, 1 = paling atas
    protected static ?int $sort = 1;

    // Fungsi helper untuk menghitung persentase
    private function calculatePercentageChange($current, $previous): float
    {
        if ($previous == 0) {
            // Jika bulan lalu 0, anggap kenaikan 100% jika ada data bulan ini
            return $current > 0 ? 100.0 : 0.0;
        }
        return (($current - $previous) / $previous) * 100;
    }

    protected function getStats(): array
    {
        // Tentukan tanggal
        $now = Carbon::now();
        $startOfCurrentMonth = $now->copy()->startOfMonth();
        $startOfPreviousMonth = $now->copy()->subMonth()->startOfMonth();
        $endOfPreviousMonth = $startOfPreviousMonth->copy()->endOfMonth();

        // 1. Total Produk
        $totalProducts = Product::count();
        $productsLastMonth = Product::where('created_at', '<=', $endOfPreviousMonth)->count();
        $productsChange = $this->calculatePercentageChange($totalProducts, $productsLastMonth); // Ini perbandingan total, bukan bulanan

        // 2. Total Kategori
        $totalCategories = Category::count();
        $categoriesLastMonth = Category::where('created_at', '<=', $endOfPreviousMonth)->count();
        $categoriesChange = $this->calculatePercentageChange($totalCategories, $categoriesLastMonth);

        // 3. Total Pengguna (Pelanggan)
        $totalUsers = User::where('is_admin', false)->count();
        $usersLastMonth = User::where('is_admin', false)->where('created_at', '<=', $endOfPreviousMonth)->count();
        $usersChange = $this->calculatePercentageChange($totalUsers, $usersLastMonth);

        // 4. Pesanan Bulan Ini
        $ordersThisMonth = Order::where('created_at', '>=', $startOfCurrentMonth)->count();
        $ordersLastMonth = Order::whereBetween('created_at', [$startOfPreviousMonth, $endOfPreviousMonth])->count();
        $ordersChange = $this->calculatePercentageChange($ordersThisMonth, $ordersLastMonth);
        $ordersChangeDescription = 'vs bulan lalu';

        return [
            Stat::make('Total Produk', $totalProducts)
                ->description(number_format($productsChange, 2) . '% vs total sebelumnya') // Gambar agak ambigu, kita pakai perbandingan total
                ->descriptionIcon($productsChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color('primary'),

            Stat::make('Total Kategori', $totalCategories)
                ->description(number_format($categoriesChange, 2) . '% vs total sebelumnya')
                ->descriptionIcon($categoriesChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color('warning'),

            Stat::make('Total Pengguna', $totalUsers)
                ->description(number_format($usersChange, 2) . '% vs total sebelumnya')
                ->descriptionIcon($usersChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color('danger'),

            Stat::make('Pesanan Bulan Ini', $ordersThisMonth)
                ->description(number_format($ordersChange, 2) . '% ' . $ordersChangeDescription)
                ->descriptionIcon($ordersChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color('success'),
        ];
    }
}
