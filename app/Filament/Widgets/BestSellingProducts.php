<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class BestSellingProductsWidget extends BaseWidget
{
    // Atur urutan, 4 = di bawah chart
    protected static ?int $sort = 4;

    // Ambil 1 baris penuh
    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading = 'Produk Terlaris';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                // Query: Ambil produk, hitung total penjualan dari order_items
                Product::query()
                    ->with('category') // Eager load relasi kategori
                    // Buat kolom 'total_penjualan' baru
                    ->selectRaw(
                        'products.*, ' .

                        // Duplikat data stok ke kolom virtual 'stock_status'
                        'products.stock as stock_status, ' .

                        // Hitung total penjualan
                        '(SELECT SUM(quantity) FROM order_items WHERE order_items.product_id = products.id) as total_penjualan'
                    )
                    // Urutkan berdasarkan kolom virtual 'total_penjualan'
                    ->orderByDesc('total_penjualan')
                    ->limit(5) // Ambil 5 teratas
            )
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Produk'),

                TextColumn::make('category.name')
                    ->label('Kategori'),

                TextColumn::make('total_penjualan')
                    ->label('Penjualan')
                    ->suffix(' unit')
                    ->sortable(),

                TextColumn::make('stock')
                    ->label('Stok')
                    ->suffix(' kg')
                    ->sortable(),

                // Kolom Status (Stok Aman / Stok Sedang)
                BadgeColumn::make('stock_status')
                    ->label('Status')
                    // Format tampilan badge berdasarkan stok
                   ->formatStateUsing(function ($state): string {
            $stock = (int) $state; // $state adalah nilai dari stock_status
            if ($stock <= 0) {
                return 'Stok Habis';
            }
            if ($stock < 20) {
                return 'Stok Sedang';
            }
            return 'Stok Aman';
        })
                    // Atur warna badge berdasarkan stok
                    ->color(function ($state): string {
            $stock = (int) $state;
            if ($stock <= 0) {
                return 'danger';
            }
            if ($stock < 20) {
                return 'warning';
            }
            return 'success';
        }),
            ])
            ->paginated(false)
            ->striped();
    }
}
