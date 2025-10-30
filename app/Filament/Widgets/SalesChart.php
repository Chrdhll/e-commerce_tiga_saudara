<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SalesChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Penjualan (7 Hari Terakhir)';
    protected static ?string $maxHeight = '300px';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        // Ambil data order 7 hari terakhir, group by tanggal
        $salesData = Order::query()
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        // Siapkan data untuk chart
        $labels = [];
        $data = [];

        // Loop 7 hari ke belakang
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $labels[] = $date->format('d M'); // Label: 24 Okt, 25 Okt, ...

            // Cari data penjualan di tanggal tsb
            $sale = $salesData->firstWhere('date', $date->format('Y-m-d'));
            $data[] = $sale ? $sale->count : 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Pesanan',
                    'data' => $data,
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'borderColor' => 'rgb(54, 162, 235)',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line'; // Tipe grafik: line, bar, pie, dll.
    }
}
