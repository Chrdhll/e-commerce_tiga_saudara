<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Setting;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\SettingResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Manajemen Admin';
    protected static ?string $navigationLabel = 'Pengaturan Toko';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    // Ini akan membuat kolom 'group_key' bohongan di level SQL
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->select(
                '*', // Ambil semua kolom asli
                // Buat kolom 'group_key' pakai SQL CASE
                DB::raw("CASE 
                    WHEN `key` LIKE 'hero_%' THEN 'Homepage (Hero)'
                    WHEN `key` LIKE 'about_%' THEN 'Halaman Tentang Kami'
                    WHEN `key` LIKE 'contact_%' THEN 'Kontak, Footer & Peta'
                    WHEN `key` LIKE 'social_%' THEN 'Sosial Media'
                    WHEN `key` LIKE 'embed_%' THEN 'Embeds'
                    ELSE 'Lainnya'
                END as group_key")
            );
    }

    public static function form(Form $form): Form
    {
        
return $form
            ->schema([
                TextInput::make('key')
                    ->label('Pengaturan')
                    ->disabled()
                    ->columnSpanFull(),
                Forms\Components\Grid::make(1)
                    ->schema(function (Setting $record) {
                        $key = $record->key;
                        $field = null;

                        // === TIPE INPUT ===
                        if (in_array($key, ['hero_image', 'about_story_image'])) {
                            // 1. Tipe UPLOAD GAMBAR
                            $field = FileUpload::make('value')
                                        ->label('Gambar')
                                        ->image()
                                        ->directory('setting-images');

                        } elseif (in_array($key, [
                            // Daftar Textarea
                            'contact_address', 'embed_google_maps', 'hero_subtitle',
                            'about_header_subtitle', 'about_story_p1', 'about_story_p2',
                            'about_story_p3', 'about_vm_subtitle', 'about_visi_text',
                            'contact_op_hours', 'contact_helpline_subtitle'
                        ])) {
                            // 2. Tipe TEXTAREA (Teks Panjang)
                            $field = Textarea::make('value')
                                        ->label('Nilai')
                                        ->rows(6);

                        } else {
                            // 3. Tipe TEXTINPUT (Teks Pendek)
                            $field = TextInput::make('value')
                                        ->label('Nilai');
                        }

                        // === HELPER TEXT ===
                        if ($key === 'embed_google_maps') {
                            $field->helperText('Salin link "Embed a map" dari Google Maps.');
                        }
                        if ($key === 'whatsapp_number') {
                            $field->helperText('Format 62 (misal: 62812...). Untuk redirect checkout WA.');
                        }
                        if ($key === 'contact_op_hours') {
                            $field->helperText('Gunakan tag <br> untuk pindah baris. Cth: Senin - Sabtu<br>Minggu Tutup');
                        }

                        return [$field->columnSpanFull()];
                    }),
            ])
            ->columns(1);

    }

    public static function table(Table $table): Table
    {
       return $table
            ->columns([
                TextColumn::make('key')
                    ->label('Pengaturan')
                    ->searchable(),
                TextColumn::make('value')
                    ->label('Nilai')
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->value),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([])
            
            // Logika Grup
            ->groups([
                Tables\Grouping\Group::make('group_key')
                    ->label('Grup Pengaturan')
                    ->collapsible(),
            ])
            ->defaultGroup('group_key');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSettings::route('/'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}