<?php

namespace App\Filament\Customer\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\PaketSaya;
use Filament\Tables\Table;
use Filament\Facades\Filament;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\Layout\Split;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Customer\Resources\PaketSayaResource\Pages;
use App\Filament\Customer\Resources\PaketSayaResource\RelationManagers;

class PaketSayaResource extends Resource
{
    protected static ?string $model = PaketSaya::class;

    // protected static ?string $navigationIcon = 'heroicon-o-heart';

    protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';

    protected static ?int $navigationSort = 1;

    protected static ?string $slug = 'paket-sayas';

    protected static ?string $navigationLabel = 'My Account';

    /**
     * NO CREATE / EDIT FROM HERE
     */
    public static function canCreate(): bool
    {
        return true;
    }

    public static function canEdit($record): bool
    {
        return false;
    }


    public static function canAccess(): bool
    {
        return Filament::getCurrentPanel()?->getId() === 'customer';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('customer_id')
                    ->required()
                    ->readOnly()
                    ->default(auth()->id()),
                Forms\Components\TextInput::make('booking_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('payment_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('created_by')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
                ->emptyStateHeading('Belum ada Paket di Booking')
                ->emptyStateDescription('Silakan lakukan booking Paket Umroh terlebih dahulu.')
                ->emptyStateIcon('heroicon-o-calendar-days')
                ->emptyStateActions([
                    // Tables\Actions\Action::make('booking')
                    //     ->label('Booking Paket Umroh')
                    //     ->url(route('filament.customer.resources.bookings.index'))
                    //     ->icon('heroicon-o-plus'),
                ])
            ->columns([

                Split::make([
                    Tables\Columns\TextColumn::make('customer.user_id.name')
                        ->weight(FontWeight::Bold)
                        ->searchable()
                        ->sortable(),
                    Tables\Columns\TextColumn::make('payment_id'),
                ])
                // Tables\Columns\TextColumn::make('customer_id')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('booking_id')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('payment_id')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('created_by')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('created_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
                // Tables\Columns\TextColumn::make('updated_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListPaketSayas::route('/'),
            'create' => Pages\FormPaketSaya::route('/create'),
            'edit' => Pages\EditPaketSaya::route('/{record}/edit'),
        ];
    }

    // public static function getEloquentQuery(): Builder
    // {
    //     return parent::getEloquentQuery()
    //         ->where('customer_id', Filament::auth()->id());
    // }
    /**
     * CUSTOMER ONLY SEE THEIR OWN BOOKINGS
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('customer_id', Filament::auth()->id())
            ->latest();
    }
}
