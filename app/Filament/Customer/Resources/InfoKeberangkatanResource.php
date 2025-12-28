<?php

namespace App\Filament\Customer\Resources;


use Filament\Tables;
use App\Models\Booking;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Facades\Filament;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Customer\Resources\InfoKeberangkatanResource\Pages;
use App\Filament\Customer\Resources\InfoKeberangkatanResource\RelationManagers;


class InfoKeberangkatanResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    public static function canAccess(): bool
    {
        return Filament::getCurrentPanel()?->getId() === 'customer';
    }

    protected static ?int $navigationSort = 5;

     protected static ?string $label = 'Info Keberangkatan';

    protected static ?string $navigationLabel = 'Info Keberangkatan';

    protected static ?string $title = 'Info Keberangkatan';

    protected static ?string $slug = 'info-keberangkatan';

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
              ->emptyStateHeading('Belum ada info keberangkatan')
                ->emptyStateDescription('Silakan Lengkapi Data Profile & Lakukan Booking Paket Umroh Terlebih Dahulu.')
                ->emptyStateIcon('heroicon-o-calendar-days')
                ->emptyStateActions([
                    // Tables\Actions\Action::make('booking')
                    //     ->label('Booking Paket Umroh')
                    //     ->url(route('filament.customer.resources.bookings.index'))
                    //     ->icon('heroicon-o-plus'),
                ])
            ->columns([
                Tables\Columns\TextColumn::make('booking_code')
                    ->label('Kode Booking')
                    ->searchable(),

                Tables\Columns\TextColumn::make('paketUmroh.nama_paket')
                    ->label('Paket Umroh'),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'success' => 'confirmed',
                        'warning' => 'pending',
                        'danger' => 'canceled',
                    ]),

                Tables\Columns\TextColumn::make('total_price')
                    ->money('IDR'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Lihat Jadwal'),
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
            'index' => Pages\ListInfoKeberangkatans::route('/'),
            'create' => Pages\CreateInfoKeberangkatan::route('/create'),
            'edit' => Pages\EditInfoKeberangkatan::route('/{record}/edit'),
        ];
    }

    // public static function getEloquentQuery(): Builder
    // {
    //     return parent::getEloquentQuery()
    //         ->withoutGlobalScopes([
    //             SoftDeletingScope::class,
    //         ]);
    // }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('customer_id', Auth::id())
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
