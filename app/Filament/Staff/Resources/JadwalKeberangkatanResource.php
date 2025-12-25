<?php

namespace App\Filament\Staff\Resources;

use App\Filament\Staff\Resources\JadwalKeberangkatanResource\Pages;
use App\Filament\Staff\Resources\JadwalKeberangkatanResource\RelationManagers;
use App\Models\JadwalKeberangkatan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JadwalKeberangkatanResource extends Resource
{
    protected static ?string $model = JadwalKeberangkatan::class;

    protected static ?string $navigationGroup = "Kelola Jadwal";

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('paket_umroh_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('tour_leader_id')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('muthawif_id')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('maskapai_id')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('bandara_id')
                    ->numeric()
                    ->default(null),
                Forms\Components\DatePicker::make('tanggal_keberangkatan')
                    ->required(),
                Forms\Components\TextInput::make('jam_keberangkatan'),
                Forms\Components\DatePicker::make('tanggal_kembali'),
                Forms\Components\TextInput::make('quota')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('sisa_quota')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('status')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('paket_umroh_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tour_leader_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('muthawif_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('maskapai_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('bandara_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_keberangkatan')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jam_keberangkatan'),
                Tables\Columns\TextColumn::make('tanggal_kembali')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quota')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sisa_quota')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListJadwalKeberangkatans::route('/'),
            'create' => Pages\CreateJadwalKeberangkatan::route('/create'),
            'edit' => Pages\EditJadwalKeberangkatan::route('/{record}/edit'),
        ];
    }
}
