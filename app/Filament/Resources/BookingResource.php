<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use App\Models\Booking;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\BookingResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BookingResource\RelationManagers;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationGroup = "Kelola Customer";

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationIcon = 'heroicon-o-key';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make([
                    Section::make([
                        //  Select::make('customer_id')
                        //     ->label('Customer')
                        //     ->options(fn () => \App\Models\Customer::all()
                        //         ->mapWithKeys(fn($c) => [$c->id => (string) ($c->nama_ktp ?? '—')])
                        //         ->toArray())
                        //     ->preload()
                        //     ->required(),

                        // Select::make('customer_id')
                        //     ->label('Customer')
                        //     ->relationship('customer', 'nama_ktp')
                        //     ->reactive()
                        //     ->afterStateUpdated(
                        //         fn($state, callable $set, callable $get) =>
                        //         $set('booking_code', static::generateBookingCode(
                        //             customerId: $state,
                        //             paketId: $get('paket_umroh_id')
                        //         ))
                        //     )
                        //     ->required(),
                        Select::make('customer_id')
                            ->label('Customer')
                            ->relationship('customer', 'nama_ktp')
                            ->getOptionLabelFromRecordUsing(
                                fn($record) => $record->nama_ktp
                                    ?? 'Customer #' . $record->id
                            )
                            ->reactive()
                            ->afterStateUpdated(
                                fn($state, callable $set, callable $get) =>
                                $set('booking_code', static::generateBookingCode(
                                    customerId: $state,
                                    paketId: $get('paket_umroh_id')
                                ))
                            )
                            ->required(),

                        TextInput::make('booking_code')
                            ->label('Booking Code')
                            ->prefix('ADW-')
                            ->readOnly()
                            ->dehydrated()
                            ->required()
                            ->default(fn() => static::generateBookingCode()),
                        //   TextInput::make('booking_code')
                        //     ->prefix('ADW-')
                        //     ->required()
                        //     ->maxLength(255),
                    ]),

                    Section::make([
                        Select::make('paket_umroh_id')
                            ->label('Pilih Paket Umroh')
                            ->relationship('paketUmroh', 'nama_paket')
                            ->getOptionLabelFromRecordUsing(function ($record) {
                                $tanggal = $record->tanggal_start
                                    ? Carbon::parse($record->tanggal_start)->translatedFormat('d M Y')
                                    : '—';

                                $kuota = $record->kuota;

                                return "{$record->nama_paket} — {$tanggal} -> Kuota : {$kuota} Org";
                            })
                            ->preload()
                            ->reactive()
                            ->columnSpanFull()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $paket = \App\Models\PaketUmroh::find($state);
                                if ($paket) {
                                    $set('tanggal_keberangkatan', $paket->tanggal_start);
                                    $set('tanggal_kembali', $paket->tanggal_end);
                                    $set('quota', $paket->kuota);
                                    $set('sisa_quota', $paket->kuota);
                                    $set('total_price', (float) $paket->harga_paket);
                                } else {
                                    $set('tanggal_keberangkatan', null);
                                    $set('tanggal_kembali', null);
                                    $set('quota', null);
                                    $set('sisa_quota', null);
                                    $set('total_price', null);
                                }
                            }),
                        // TextInput::make('quota')
                        //     ->label('Kuota')
                        //     ->numeric()
                        //     ->disabled() // Disable editing
                        //     ->prefix('Paket')
                        //     ->suffix('Orang')
                        //     ->dehydrated(false), // Don't hydrate this field

                        // TextInput::make('quota')
                        //     ->label('Kuota')
                        //     ->readOnly()
                        //     ->suffix('Orang')
                        //     ->formatStateUsing(
                        //         fn($record) =>
                        //         $record?->jadwalKeberangkatan?->quota
                        //     ),

                        TextInput::make('sisa_quota')
                            ->label('Sisa Kuota')
                            ->readOnly()
                            ->suffix('Orang')
                            ->formatStateUsing(fn ($record) =>
                                $record?->jadwalKeberangkatan?->sisa_quota
                        ),

                        TextInput::make('total_price')
                            ->label("Biaya")
                            ->readOnly()
                            ->dehydrated(true) // send to DB
                            ->prefix('Rp.'),

                        // TextInput::make('tanggal_keberangkatan')
                        //     ->label("Jadwal Keberangkatan")
                        //     ->disabled() // Disable editing
                        //     ->dehydrated(false) // Don't hydrate this field
                        //     ->prefix('Tanggal :'),

                        Select::make('jadwal_keberangkatan_id')
                            ->label('Jadwal Keberangkatan')
                            ->options(
                                fn() => \App\Models\JadwalKeberangkatan::query()
                                    ->orderBy('tanggal_keberangkatan')
                                    ->get()
                                    ->mapWithKeys(fn($c) => [
                                        $c->id => Carbon::parse($c->tanggal_keberangkatan)
                                            ->translatedFormat('l, d M Y'),
                                    ])
                                    ->toArray()
                            )
                            ->searchable()
                            ->preload()
                            ->required(),

                    ])
                        ->columns(3),
                ])->aside(false),



                Select::make('status')
                    ->label("Status Booking")
                    ->options([
                        'waiting_payment' => 'Menunggu Pembayaran',
                        'partial' => 'Sudah DP',
                        'paid' => 'Lunas',
                        'pending' => 'Batal',
                        'canceled' => 'Dibatalkan',
                    ])
                    ->default('waiting_payment')
                    ->required(),

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

                // Forms\Components\TextInput::make('created_by')
                //     ->readOnly()
                //     ->default(auth()->id()),

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
                Tables\Columns\TextColumn::make('status')
                    ->alignCenter()
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'paid' => 'success',
                        'partial' => 'warning',
                        'pending' => 'danger',
                        'waiting_payment' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('total_price')
                    ->prefix('Rp. ')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sisa_tagihan')
                    ->prefix('Rp. ')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('metode_pembayaran')
                    ->label('Metode Pembyaran')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_by')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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

    protected static function syncPaketData(?int $paketId, callable $set): void
    {
        if (! $paketId) {
            return;
        }

        $paket = \App\Models\PaketUmroh::find($paketId);

        if (! $paket) {
            return;
        }

        $set('quota', $paket->kuota);
        $set('sisa_quota', $paket->kuota);
        $set('total_price', (float) $paket->harga_paket);
    }

    protected static function generateBookingCode(
        ?int $customerId = null,
        ?int $paketId = null
    ): string {
        $customer = $customerId
            ? \App\Models\Customer::find($customerId)
            : null;

        $paket = $paketId
            ? \App\Models\PaketUmroh::find($paketId)
            : null;

        $customerPart = $customer
            ? Str::upper(Str::limit(Str::slug($customer->nama_ktp, ''), 5, ''))
            : 'CUST';

        // $paketPart = $paket
        //     ? Str::upper(Str::limit(Str::slug($paket->nama_paket, ''), 5, ''))
        //     : 'PKT';

        $datePart = now()->format('Ymd');

        do {
            $randomPart = str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);

            // $code = "ADW-{$paketPart}-{$customerPart}-{$datePart}-{$randomPart}";
            $code = "ADW-{$customerPart}-{$datePart}-{$randomPart}";
        } while (
            \App\Models\Booking::where('booking_code', $code)->exists()
        );

        return $code;
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
