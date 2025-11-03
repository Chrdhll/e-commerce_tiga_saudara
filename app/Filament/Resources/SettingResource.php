<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Setting;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Cache;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\SettingResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    // 2. GANTI ICON & GRUP
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Manajemen Admin';
    protected static ?string $navigationLabel = 'Pengaturan Toko';

    // 3. KITA TIDAK INGIN ADMIN MEMBUAT / MENGHAPUS KEY
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
                // Kunci-nya (key) tidak boleh diedit
                TextInput::make('key')
                    ->label('Pengaturan')
                    ->disabled(),

                // Nilai-nya (value) bisa diedit
                Textarea::make('value')
                    ->label('Nilai')
                    ->required()

                    // 4. HAPUS CACHE SETELAH DISIMPAN
                    ->afterStateUpdated(function ($record) {
                        // Hapus cache lama agar data baru langsung dipakai
                        Cache::forget('setting.' . $record->key);
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('key')
                    ->label('Pengaturan'),
                TextColumn::make('value')
                    ->label('Nilai')
                    ->limit(50), // Batasi teks
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(), // Hanya bisa edit
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]), // Matikan bulk delete
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSettings::route('/'),
            // 'create' => Pages\CreateSetting::route('/create'), // Matikan Create
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}
