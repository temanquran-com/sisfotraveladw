<?php

namespace App\Filament\Staff\Resources;

use App\Filament\Staff\Resources\InfoDelayResource\Pages;
use App\Filament\Staff\Resources\InfoDelayResource\RelationManagers;
use App\Models\JadwalKeberangkatan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InfoDelayResource extends Resource
{
    protected static ?string $model = JadwalKeberangkatan::class;

    protected static ?string $navigationGroup = "Kelola Jadwal";

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListInfoDelays::route('/'),
            'create' => Pages\CreateInfoDelay::route('/create'),
            'edit' => Pages\EditInfoDelay::route('/{record}/edit'),
        ];
    }
}
