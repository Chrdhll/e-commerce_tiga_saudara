<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Order;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Exports\OrdersExport;
use Filament\Tables\Actions\ExportAction;
use App\Filament\Resources\OrderResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\OrderResource\RelationManagers;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationGroup = 'Manajemen Toko';
    protected static ?int $navigationSort = 3;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('user');
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {

        return $form
                ->schema([
                    // Hanya tampilkan field yang boleh diedit
                    Select::make('status')
                        ->options([
                            'pending' => 'Menunggu',
                            'processing' => 'Diproses',
                            'shipped' => 'Dikirim',
                            'completed' => 'Selesai',
                            'cancelled' => 'Dibatalkan',
                        ])
                        ->required(),

                    Select::make('payment_status')
                        ->options([
                            'unpaid' => 'Belum Dibayar',
                            'paid' => 'Sudah Dibayar',
                        ])
                        ->required(),

                    // Tampilkan data lain sebagai Read-Only (jika perlu)
                    TextInput::make('user.name')
                        ->label('Customer')
                        ->disabled(),
                    TextInput::make('total_price')
                        ->money('IDR')
                        ->disabled(),
                ]);

    }

    public static function table(Table $table): Table
    {

        return $table
                ->columns([
                    TextColumn::make('invoice_number')
                        ->searchable(),
                    TextColumn::make('user.name')
                        ->label('Customer')
                        ->searchable(),
                    TextColumn::make('total_price')
                        ->money('IDR')
                        ->sortable(),

                    SelectColumn::make('status')
                        ->options([
                            'pending' => 'Menunggu',
                            'processing' => 'Diproses',
                            'shipped' => 'Dikirim',
                            'completed' => 'Selesai',
                            'cancelled' => 'Dibatalkan',
                        ])
                        ->sortable(),

                    SelectColumn::make('payment_status')
                        ->label('Status Bayar')
                        ->options([
                            'unpaid' => 'Belum Dibayar',
                            'paid' => 'Sudah Dibayar',
                        ])
                        ->sortable(),

                    TextColumn::make('created_at')
                    ->label('Tgl. Pesan') 
                    ->dateTime()
                    ->sortable(),
                ])
                ->filters([
                    // Filter berdasarkan status
                    SelectFilter::make('status')
                        ->options([
                            'pending' => 'Menunggu',
                            'processing' => 'Diproses',
                            'shipped' => 'Dikirim',
                            'completed' => 'Selesai',
                            'cancelled' => 'Dibatalkan',
                        ]),
                ])
                ->actions([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\ViewAction::make(),
                ])
                ->headerActions([
                  ExportAction::make()
                ->label('Download Laporan (Excel)')
                ->exporter(OrdersExport::class)
                ->fileName(fn (): string => 'laporan-pesanan-'.date('Y-m-d').'.xlsx')
                ]);


    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}

