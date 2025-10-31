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
                    ->withCount(['orderItems as total_penjualan' => function (Builder $query) {
                        // 'orderItems' adalah nama relasi di model Product
                        $query->select(DB::raw('sum(quantity)'));
                    }])
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
                BadgeColumn::make('status')
                    ->label('Status')
                    // Format tampilan badge berdasarkan stok
                    ->formatStateUsing(fn ($state, $record): string => $record->stock < 20 ? 'Stok Sedang' : 'Stok Aman')
                    // Atur warna badge berdasarkan stok
                    ->color(fn ($state, $record): string => $record->stock < 20 ? 'warning' : 'success'),
            ])
            ->paginated(false) // Matikan paginasi
            ->striped(); // Buat tabel belang-belang
    }
}
