<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\Product;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class ProductGrowthChart extends ChartWidget
{
    protected static ?string $heading = 'Pertumbuhan Produk';

    // Atur urutan, 3 = di sebelah Sales Chart
    protected static ?int $sort = 3;
    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        return Cache::remember('product-growth-chart', now()->addMinutes(10), function () {
            $days = 30; // Tampilkan data 30 hari terakhir
            $startDate = Carbon::now()->subDays($days)->startOfDay();

            // 1. Ambil data produk baru per hari
            $productData = Product::query()
                ->where('created_at', '>=', $startDate)
                ->select(
                    DB::raw('DATE(created_at) as date'),
                    DB::raw('COUNT(*) as count')
                )
                ->groupBy('date')
                ->orderBy('date', 'ASC')
                ->get();

            // 2. Dapatkan jumlah produk awal (sebelum 30 hari lalu)
            $startingCount = Product::where('created_at', '<', $startDate)->count();

            $labels = [];
            $data = [];
            $cumulativeCount = $startingCount;

            // 3. Loop 30 hari ke belakang untuk membuat data kumulatif
            foreach ($productData as $product) {
                $labels[] = $product->date;
                $cumulativeCount += $product->count;
                $data[] = $cumulativeCount;
            }

            return [
                'datasets' => [
                    [
                        'label' => 'Total Produk',
                        'data' => $data,
                        'borderColor' => '#f97316', // Warna oranye
                        'tension' => 0.1,
                    ],
                ],
                'labels' => $labels,
            ];
        });
    }

    protected function getType(): string
    {
        return 'line';
    }
}
