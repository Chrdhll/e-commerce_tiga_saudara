<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Set;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Str;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

   protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $navigationGroup = 'Manajemen Toko';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {

        return $form
                ->schema([
                    // Relasi ke Kategori, jadikan Dropdown
                    Select::make('category_id')
                        ->relationship('category', 'name') // 'category' = nama relasi di Model, 'name' = kolom yg ditampilkan
                        ->required(),

                    // Input Nama, otomatis update Slug
                    TextInput::make('name')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true) // 'live' agar bisa update field lain
                        ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),

                    TextInput::make('slug')
                        ->required()
                        ->maxLength(255)
                        // Pastikan slug unik, tapi abaikan record saat ini (untuk edit)
                        ->unique(Product::class, 'slug', ignoreRecord: true),

                    // Harga, dengan prefix 'Rp'
                    TextInput::make('price')
                        ->required()
                        ->numeric()
                        ->prefix('Rp'),

                    TextInput::make('stock')
                        ->required()
                        ->numeric(),

                    // Deskripsi, pakai Rich Text Editor
                    RichEditor::make('description')
                        ->columnSpanFull(), // Ambil 1 baris penuh

                    // Upload Gambar
                    FileUpload::make('image')
                        ->image() // Hanya terima gambar
                        ->directory('product-images') // Simpan di 'storage/app/public/product-images'
                        ->columnSpanFull(),
                ]);

    }

    public static function table(Table $table): Table
    {

        return $table
                ->columns([
                    // Tampilkan gambar
                    ImageColumn::make('image'),

                    TextColumn::make('name')
                        ->searchable(), // Aktifkan pencarian

                    // Tampilkan nama kategori dari relasi
                    TextColumn::make('category.name')
                        ->sortable(),

                    // Format harga sebagai mata uang
                    TextColumn::make('price')
                        ->money('IDR')
                        ->sortable(),

                    TextColumn::make('stock')
                        ->sortable(),

                    TextColumn::make('created_at')
                        ->dateTime()
                        ->sortable()
                        ->toggleable(isToggledHiddenByDefault: true), // Sembunyikan default
                ])
                ->filters([
                    // Tambahkan filter berdasarkan kategori
                    SelectFilter::make('category')
                        ->relationship('category', 'name')
                ])
                ->actions([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(), // Tambahkan aksi hapus
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
