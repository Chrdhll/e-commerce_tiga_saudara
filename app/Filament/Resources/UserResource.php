<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Manajemen Pengguna';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {

        return $form
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->disabled(), // Tidak bisa diedit
                        TextInput::make('email')
                            ->email()
                            ->required()
                            ->disabled(), // Tidak bisa diedit

                        Toggle::make('is_admin')
                            ->label('Jadikan Admin?')
                            ->required(),
                    ]);

    }

    public static function table(Table $table): Table
    {
        
return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable(),

                // Tampilkan status admin dengan Icon
                IconColumn::make('is_admin')
                    ->label('Admin')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-user'),

                TextColumn::make('email_verified_at')
                    ->label('Terverifikasi')
                    ->dateTime('d M Y')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Tanggal Daftar')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
