<?php

namespace App\Filament\Customer\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Booking;
use Filament\Forms\Form;
use App\Models\PaketSaya;
use Filament\Tables\Table;
use Filament\Facades\Filament;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\Layout\Split;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Customer\Clusters\MyAccount;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Customer\Resources\PaketSayaResource\Pages;
use App\Filament\Customer\Resources\PaketSayaResource\RelationManagers;

class PaketSayaResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';

    protected static ?int $navigationSort = 2;

    // public static function getLabel(): string
    // {
    //     return 'Booking Paket';
    // }

    protected static ?string $slug = 'paket-sayas';

    // protected static ?string $cluster = MyAccount::class;cs

    protected static ?string $navigationLabel = 'Booking';

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
                // Forms\Components\TextInput::make('customer_id')
                //     ->required()
                //     ->readOnly()
                //     ->default(auth()->id()),
                // Forms\Components\TextInput::make('booking_id')
                //     ->required()
                //     ->numeric(),
                // Forms\Components\TextInput::make('payment_id')
                //     ->required()
                //     ->numeric(),
                // Forms\Components\TextInput::make('created_by')
                //     ->required()
                //     ->numeric(),
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
                    TextColumn::make('customer.user.name')
                        ->icon('heroicon-o-lock-closed')
                        ->label('Nama Customer')
                        ->weight(FontWeight::Bold),

                    TextColumn::make('paket_info')
                        ->label('Paket Info')
                        ->columnSpan(3)
                        ->html(true)
                        ->badge()
                        ->color(fn ($state) =>
                            str_contains($state, '-') ? 'success' : 'success'
                        )
                        // ->getStateUsing(fn(Booking $record) => sprintf(
                        //     '<strong>Kode Booking:</strong> %s<br><strong>Paket:</strong> %s<br><strong>Biaya Umroh:</strong> %s',
                        //     e($record->booking_code),
                        //     e($record->paketUmroh?->nama_paket ?? '-'),
                        //     e($record->paketUmroh?->harga_paket ?? '-')
                        // )),
                        ->getStateUsing(fn(Booking $record) => sprintf(
                            '<strong>Kode Booking:</strong> %s<br><strong>Paket:</strong> %s<br>',
                            e($record->booking_code),
                            e($record->paketUmroh?->nama_paket ?? '-'),
                        )),


                    TextColumn::make('total_dibayar')
                        ->label('Sudah Dibayar')
                        ->weight(FontWeight::Bold)
                        ->badge()
                        ->prefix('Sudah Bayar : ')
                        ->state(
                            fn(Booking $record) =>
                            $record->payments->sum('jumlah_bayar')
                        )
                        ->money('IDR', locale: 'id'),

                ])
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


    /**
     * CUSTOMER ONLY SEE THEIR OWN BOOKINGS
     */
    public static function getEloquentQuery(): Builder
    {
        $customerId = Filament::auth()->user()?->customer?->id;

        return parent::getEloquentQuery()
            ->where('customer_id', $customerId)
            ->latest();
    }
}
