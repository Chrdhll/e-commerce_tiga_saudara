<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Set;
use Illuminate\Support\Str;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\CategoryResource\RelationManagers;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';
    protected static ?string $navigationGroup = 'Manajemen Toko';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {

        return $form
                ->schema([
                    Grid::make(2) // Buat layout 2 kolom
                        ->schema([
                            // KOLOM KIRI
                            Grid::make(1)
                                ->schema([
                                    TextInput::make('name')
                                        ->required()
                                        ->maxLength(255)
                                        ->live(onBlur: true) // 'live' agar bisa update field lain
                                        ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))
                                        ->label('Nama Kategori'),

                                    TextInput::make('slug')
                                        ->required()
                                        ->maxLength(255)
                                        ->label('Slug (URL)')
                                        // Pastikan slug unik, tapi abaikan record saat ini (untuk edit)
                                        ->unique(ignoreRecord: true),
                                ])->columnSpan(1),

                            // KOLOM KANAN
                            Grid::make(1)
                                ->schema([
                                    FileUpload::make('image')
                                        ->image() // Hanya terima gambar
                                        ->directory('category-images') // Simpan di 'storage/app/public/category-images'
                                        ->imageEditor() // Aktifkan editor gambar (crop, rotate)
                                        ->label('Gambar Kategori'),
                                ])->columnSpan(1),
                        ]),
                ]);

    }

    public static function table(Table $table): Table
    {

        return $table
                ->columns([
                    ImageColumn::make('image')
                        ->label('Gambar')
                        ->square(), // Buat gambar jadi kotak agar rapi

                    TextColumn::make('name')
                        ->label('Nama Kategori')
                        ->searchable() // Aktifkan pencarian
                        ->sortable(),

                    TextColumn::make('slug')
                        ->label('Slug')
                        ->searchable(),

                    // INI NILAI LEBIH: Menghitung jumlah produk
                    TextColumn::make('products_count')
                        ->counts('products') // 'products' adalah nama relasi di Model Kategori
                        ->label('Jumlah Produk')
                        ->sortable(),

                    TextColumn::make('created_at')
                        ->label('Dibuat Pada')
                        ->dateTime('d M Y')
                        ->sortable()
                        ->toggleable(isToggledHiddenByDefault: true), // Sembunyikan default
                ])
                ->filters([
                    // (Kita bisa tambahkan filter nanti jika perlu)
                ])
                ->actions([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
                ->bulkActions([
                    Tables\Actions\BulkActionGroup::make([
                        Tables\Actions\DeleteBulkAction::make(),
                    ]),
                ]);

    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ProductsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
