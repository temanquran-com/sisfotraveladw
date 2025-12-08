<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JadwalKeberangkatanResource\Pages;
use App\Filament\Resources\JadwalKeberangkatanResource\RelationManagers;
use App\Models\JadwalKeberangkatan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TimePicker;

class JadwalKeberangkatanResource extends Resource
{
    protected static ?string $model = JadwalKeberangkatan::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\TextInput::make('paket_umroh_id')
                //     ->required()
                //     ->numeric(),
                Forms\Components\Select::make('paket_umroh_id')
                    ->label('Paket')
                    ->relationship('paketUmroh', 'nama_paket')
                    ->searchable()
                    ->preload()
                    ->default(null),
                // Forms\Components\TextInput::make('tour_leader_id')
                //     ->numeric()
                //     ->default(null),
                // Forms\Components\TextInput::make('tour_leader_name')
                //     ->maxLength(255)
                //     ->default(null),
                Forms\Components\Select::make('tour_leader_id')
                    ->label('Tour Leader')
                    ->relationship('tourLeader', 'nama_tour_leader')
                    ->searchable()
                    ->preload()
                    ->default(null),
                // Forms\Components\TextInput::make('muthawif_id')
                //     ->numeric()
                //     ->default(null),
                // Forms\Components\TextInput::make('muthawif_name')
                //     ->maxLength(255)
                //     ->default(null),
                Forms\Components\Select::make('muthawif_id')
                    ->label('Muthawif')
                    ->relationship('muthawif', 'nama_muthawif')
                    ->searchable()
                    ->preload()
                    ->default(null),
                // Forms\Components\TextInput::make('maskapai_id')
                //     ->numeric()
                //     ->default(null),
                // Forms\Components\TextInput::make('maskapai_name')
                //     ->maxLength(255)
                //     ->default(null),
                Forms\Components\Select::make('maskapai_id')
                    ->label('Maskapai')
                    ->relationship('maskapai', 'nama_maskapai')
                    ->searchable()
                    ->preload()
                    ->default(null),
                // Forms\Components\TextInput::make('bandara_id')
                //     ->numeric()
                //     ->default(null),
                // Forms\Components\TextInput::make('bandara_name')
                //     ->maxLength(255)
                //     ->default(null),

                Forms\Components\Select::make('bandara_id')
                    ->label('Bandara')
                    ->relationship('bandara', 'nama_bandara')
                    ->searchable()
                    ->preload()
                    ->default(null),
                Forms\Components\DatePicker::make('tanggal_keberangkatan')
                    ->required(),
                // Forms\Components\TextInput::make('jam_keberangkatan'),
                TimePicker::make('jam_keberangkatan')
                    ->datalist([
                        '09:00',
                        '09:30',
                        '10:00',
                        '10:30',
                        '11:00',
                        '11:30',
                        '12:00',
                    ]),
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
                Tables\Columns\TextColumn::make('tanggal_keberangkatan')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jam_keberangkatan'),
                Tables\Columns\TextColumn::make('paketUmroh.nama_paket')
                    ->label('Paket Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tourLeader.nama_tour_leader')
                    ->label('Tour Leader')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('muthawif.nama_muthawif')
                    ->label('Muthawif')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('maskapai.nama_maskapai')
                    ->label('Maskapai')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('bandara.nama_bandara')
                    ->label('Bandara')
                    ->searchable()
                    ->sortable(),


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
