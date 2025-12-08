<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Booking;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\BookingResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BookingResource\RelationManagers;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-key';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\TextInput::make('customer_id')
                //     ->required()
                //     ->numeric(),
                Forms\Components\Select::make('customer_id')
                    ->label('Customer')
                    ->relationship('customer', 'nama_ktp')
                    ->searchable()
                    ->preload()
                    ->default(null),
                Forms\Components\TextInput::make('paket_umroh_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('jadwal_keberangkatan_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('booking_code')
                    ->prefix('ADW-')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('status')
                    ->required(),
                Forms\Components\TextInput::make('total_price')
                    ->required()
                    ->numeric()
                    ->default(0.00),
                // Forms\Components\TextInput::make('metode_pembayaran'),
                Select::make('metode_pembayaran')
                    ->label("Metode Pembayaran")
                    ->options([
                    'cash' => 'Tunai',
                    'transfer' => 'Via Transfer',
                    'cicilan' => 'Cicilan',
                    ])
                    ->default('cicilan')
                    ->required(),

                Forms\Components\TextInput::make('created_by')
                    ->readOnly()
                    ->default(auth()->id()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\TextColumn::make('customer_id')
                //     ->numeric()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('customer.nama_ktp')
                    ->label('Customer Name')
                    ->searchable()
                    ->sortable(),
                // Tables\Columns\TextColumn::make('paket_umroh_id')
                //     ->numeric()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('paketUmroh.nama_paket')
                    ->label('Paket Name')
                    ->searchable()
                    ->sortable(),
                // Tables\Columns\TextColumn::make('jadwal_keberangkatan_id')
                //     ->numeric()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('jadwalKeberangkatan.tanggal_keberangkatan')
                    ->label('Jadwal')
                    ->date()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('booking_code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('total_price')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('metode_pembayaran'),
                Tables\Columns\TextColumn::make('created_by')
                    ->numeric()
                    ->sortable(),
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
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}
