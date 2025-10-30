<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        // 1. Total Pendapatan (hanya dari order yang 'completed')
        $totalRevenue = Order::where('status', 'completed')
                            ->sum('total_price');

        // 2. Pesanan Baru (yang statusnya 'pending')
        $newOrders = Order::where('status', 'pending')->count();

        // 3. Total Pelanggan (yang bukan admin)
        $totalCustomers = User::where('is_admin', false)->count();

        return [
            Stat::make('Total Pendapatan', 'Rp ' . number_format($totalRevenue, 0, ',', '.'))
                ->description('Semua pesanan selesai')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            Stat::make('Pesanan Baru', $newOrders)
                ->description('Pesanan yang belum diproses')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('warning'),

            Stat::make('Total Pelanggan', $totalCustomers)
                ->description('Jumlah pelanggan terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),
        ];
    }
}