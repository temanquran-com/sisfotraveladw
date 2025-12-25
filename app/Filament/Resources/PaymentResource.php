<?php

namespace App\Filament\Resources;


use Filament\Tables;
use App\Models\Payment;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PaymentResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PaymentResource\RelationManagers;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationGroup = "Kelola Pembayaran";

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make([
                    Select::make('booking_id')
                        ->label('Booking ID')
                        ->relationship('booking', 'booking_code')
                        ->preload()
                        ->reactive()
                        ->columnSpanFull()
                        ->afterStateUpdated(function ($state, callable $set) {
                            $paket = \App\Models\Booking::find($state);
                            if ($paket) {
                                $set('total_price',  (float) $paket->total_price);
                                $set('sisa_tagihan', (float) $paket->sisa_tagihan);
                                // $set('quota', $paket->kuota);
                                // $set('sisa_quota', $paket->kuota);
                                // $set('total_price', (float) $paket->harga_paket);
                            } else {
                                $set('total_price', null);
                                $set('sisa_tagihan', null);
                                // $set('quota', null);
                                // $set('sisa_quota', null);
                                // $set('total_price', null);
                            }
                        }),

                    TextInput::make('total_price')
                        ->label('Harga Paket')
                        ->disabled() // Disable editing
                        ->prefix('Rp.')
                        ->dehydrated(false), // Don't hydrate this field
                    TextInput::make('sisa_tagihan')
                        ->label('Sisa Tagihan')
                        ->disabled() // Disable editing
                        ->prefix('Rp.')
                        ->dehydrated(false), // Don't hydrate this field
                ])->columns(2),

                Section::make([
                    // TextInput::make('jumlah_bayar')
                    // ->prefix('Rp.')
                    // ->required()
                    // ->numeric()
                    // ->default(0.00),
                    TextInput::make('jumlah_bayar')
                        ->numeric()
                        ->required()
                        ->prefix('Rp.')
                        ->rule(function (callable $get) {
                            return function ($attribute, $value, $fail) use ($get) {
                                $booking = \App\Models\Booking::find($get('booking_id'));
                                if ($booking && $value > $booking->sisa_tagihan && $booking->sisa_tagihan > 0) {
                                    $fail('Jumlah bayar melebihi sisa tagihan.');
                                }
                            };
                        })
                        ->columnSpanFull(),

                    Section::make([
                        DatePicker::make('tanggal_bayar')
                            ->label('Tanggal Bayar')
                            ->default(now())
                            ->displayFormat('l, d M Y')
                            ->required(),

                        Select::make('metode_pembayaran')
                            ->label("Metode Pembayaran")
                            ->options([
                                'cash' => 'Cash',
                                'transfer' => 'Transfer',
                                'kartu_kredit' => 'Kartu Kredit',
                            ])
                            ->default('cash')
                            ->required(),

                        // Select::make('status')
                        //     ->label("Status")
                        //     ->options([
                        //         'verified' => 'Verified',
                        //         'pending' => 'Pending',
                        //         'rejected' => 'rejected',
                        //     ])
                        //     ->default('verified')
                        //     ->required(),
                    ])->columns(2),

                ])->columns(2),

                FileUpload::make('bukti_bayar')
                    ->label('Bukti Bayar')
                    ->image() // Ensures only image files can be uploaded
                    ->disk('public') // Store files on the 'public' disk (in `storage/app/public`)
                    ->directory('payment-files') // Store images in the 'tour-leaders' folder inside the 'public' disk
                    ->maxSize(1024) // Max size in kilobytes (1MB)
                    ->enableOpen() // Allow users to open the image
                    ->default(null), // Default value for the field

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('booking.booking_code')
                    ->label('Booking Code')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('jumlah_bayar')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_bayar')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('metode_pembayaran'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->alignCenter()
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'verified' => 'success',
                        'unverified' => 'warning',
                        'rejected' => 'danger',
                    }),
                TextColumn::make('bukti_bayar')
                    ->label('Foto')
                    ->icon('heroicon-m-photo')
                    ->tooltip(function ($record) {
                        return $record->bukti_bayar !== '-'
                            ? 'Klik untuk melihat foto'
                            : 'Foto tidak tersedia';
                    })
                    ->url(function ($record) {
                        return $record->photo_url !== '-'
                            ? asset('storage/' . $record->bukti_bayar)
                            : null;
                    })
                    ->getStateUsing(function ($record) {
                        return $record->bukti_bayar !== '-'
                            ? 'Image'
                            : '';
                    }),

                TextColumn::make('verifier.name')
                    ->label('Verifier')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
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
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}
