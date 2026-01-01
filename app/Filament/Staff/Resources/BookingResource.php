<?php

namespace App\Filament\Staff\Resources;

use stdClass;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use Filament\Actions;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Customer;
use Filament\Forms\Form;
use App\Models\PaketSaya;
use App\Models\PaketUmroh;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\DB;
use App\Models\JadwalKeberangkatan;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Support\Enums\FontWeight;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Staff\Resources\BookingResource\Pages;
use App\Filament\Staff\Resources\BookingResource\RelationManagers;


class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-key';

    protected static ?string $navigationGroup = "Kelola Booking";

    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Section::make('Paket Umroh')
                //     ->collapsible()
                //     ->schema([
                //         Card::make([
                //             Grid::make()
                //                 ->schema([
                //                     Select::make('paket_umroh_id')
                //                         ->label('Pilih Paket Umroh')
                //                         ->columnSpanFull()
                //                         // ->options(fn() => PaketUmroh::pluck('nama_paket', 'id'))
                //                         ->options(
                //                             PaketUmroh::query()
                //                                 ->orderBy('nama_paket')
                //                                 ->pluck('nama_paket', 'id')
                //                         )
                //                         ->reactive()
                //                         ->afterStateUpdated(function ($state, callable $set) {
                //                             if (! $state) {
                //                                 return;
                //                             }
                //                             $paket = PaketUmroh::find($state);
                //                             if (! $paket) {
                //                                 return;
                //                             }

                //                             // dd($paket);

                //                             // Cari jadwal keberangkatan
                //                             $jadwal = JadwalKeberangkatan::query()
                //                                 ->where('paket_umroh_id', $state)
                //                                 ->whereDate('tanggal_keberangkatan', $paket->tanggal_start)
                //                                 ->where('sisa_quota', '>', 0)
                //                                 ->first();

                //                             if (! $jadwal) {
                //                                 $this->addError('paket_id', 'Jadwal keberangkatan tidak tersedia');
                //                                 return;
                //                             }

                //                             // dd($jadwal);

                //                             // 🔑 simpan jadwal ID
                //                             $set('jadwal_keberangkatan_id', $jadwal->id);

                //                             // Simpan snapshot paket
                //                             $set('paket_details', [
                //                                 'paket_umroh_id' => $paket->id,
                //                                 'harga_paket' => $paket->harga_paket,
                //                                 'kuota' => $paket->kuota,
                //                                 'durasi_hari' => $paket->durasi_hari,
                //                                 'include'     => $paket->include,
                //                                 'exclude'     => $paket->exclude,
                //                                 'thumbnail'   => $paket->thumbnail,
                //                             ]);

                //                             // Booking code
                //                             // $set('booking_id', self::generateBookingCode(
                //                             //     auth()->id(),
                //                             //     $state
                //                             // ));
                //                         }),

                //                     Placeholder::make('jadwal_keberangkatan_id')
                //                         ->label('Jadwal')
                //                         ->extraAttributes([
                //                             'class' => 'text-lg font-semibold text-primary-400',
                //                         ])
                //                         ->content(
                //                             fn($get) =>
                //                             $get('jadwal_keberangkatan_id')
                //                                 ? 'Tanggal Berangkat :' . $get('jadwal_keberangkatan_id')
                //                                 : '-'
                //                         ),

                //                     // Nested fields showing Paket details
                //                     Section::make([
                //                         // TextInput::make('paket_details.harga_paket')
                //                         //     ->prefix('Rp.')
                //                         //     ->label('Harga Paket')
                //                         //     ->disabled()
                //                         //     ->dehydrated(true)
                //                         //     ->formatStateUsing(
                //                         //         fn($state) =>
                //                         //         $state ? number_format($state, 0, ',', '.') : null
                //                         //     ),
                //                         Placeholder::make('harga_paket_view')
                //                             ->label('Harga Paket')
                //                             ->extraAttributes([
                //                                 'class' => 'text-lg font-semibold text-primary-400',
                //                             ])
                //                             ->content(
                //                                 fn($get) =>
                //                                 $get('paket_details.harga_paket')
                //                                     ? 'Rp ' . number_format($get('paket_details.harga_paket'), 0, ',', '.')
                //                                     : '-'
                //                             ),

                //                         Placeholder::make('durasi_hari_view')
                //                             ->label('Durasi Hari')
                //                             ->extraAttributes([
                //                                 'class' => 'text-lg font-semibold text-primary-400',
                //                             ])
                //                             ->content(
                //                                 fn($get) =>
                //                                 $get('paket_details.durasi_hari')
                //                                     ? $get('paket_details.durasi_hari') . ' Hari'
                //                                     : '-'
                //                             ),
                //                         Placeholder::make('kuota_view')
                //                             ->label('Kuota Tersedia')
                //                             ->extraAttributes([
                //                                 'class' => 'text-lg font-semibold text-primary-400',
                //                             ])
                //                             ->content(
                //                                 fn($get) =>
                //                                 $get('paket_details.kuota')
                //                                     ? $get('paket_details.kuota') . ' Orang'
                //                                     : '-'
                //                             ),

                //                     ])->columns(3),

                //                     Textarea::make('paket_details.include')
                //                         ->label('Include')
                //                         ->disabled()
                //                         ->columnSpanFull()
                //                         ->rows(3)
                //                         ->extraAttributes([
                //                             'class' => 'text-lg font-semibold text-primary-400',
                //                         ])
                //                         ->dehydrated(true),

                //                     Textarea::make('paket_details.exclude')
                //                         ->label('Exclude')
                //                         ->extraAttributes([
                //                             'class' => 'text-lg font-semibold text-primary-400',
                //                         ])
                //                         ->disabled()
                //                         ->columnSpanFull()
                //                         ->rows(3)
                //                         ->dehydrated(true),
                //                 ])
                //                 ->columns(2)
                //                 ->columnSpan(1),
                //             Placeholder::make('thumbnail_preview')
                //                 // ->statePath('data')
                //                 ->label('Thumbnail')
                //                 ->extraAttributes(['class' => 'w-12 h-24'])
                //                 ->content(
                //                     fn($get) =>
                //                     $get('paket_details.thumbnail')
                //                         ? view('components.thumbnail-preview', [
                //                             'src' => $get('paket_details.thumbnail'),
                //                         ])
                //                         : '-'
                //                 ),
                //             // ->content(fn($get) => dd(
                //             //     $get('paket_details.exclude'),
                //             //     $get('paket_details.thumbnail'),
                //             //     asset('storage/' . $get('paket_details.thumbnail'))
                //             // )),

                //         ])
                //             ->columns(2), // Bind all fields to $this->data

                //     ]),

                // Section::make('Data Booking')
                //     ->collapsible()
                //     ->collapsed(false)
                //     ->schema([
                //         Select::make('customer_id')
                //             ->label('Customer')
                //             ->relationship('customer', 'nama_ktp')
                //             ->searchable()
                //             ->preload()
                //             ->reactive()
                //             ->afterStateUpdated(function ($state, callable $set) {
                //                 $customer = Customer::find($state);

                //                 $set('nama_customer', $customer?->nama_ktp);
                //             })
                //             ->required(),

                //         Placeholder::make('booking_code')
                //             ->label('Booking Code')
                //             ->extraAttributes([
                //                 'class' => 'text-lg font-semibold text-primary-400',
                //             ])
                //             ->content(function ($get) {

                //                 $paketId = $get('paket_umroh_id');
                //                 $namaCustomer = $get('nama_customer');

                //                 if (! $paketId || ! $namaCustomer) {
                //                     return '-';
                //                 }

                //                 $paket = PaketUmroh::find($paketId);
                //                 if (! $paket) {
                //                     return '-';
                //                 }

                //                 // CUSTOMER PART (STRING, bukan object)
                //                 $customerPart = Str::upper(
                //                     Str::limit(Str::slug($namaCustomer, ''), 5, '')
                //                 );

                //                 $paketPart = Str::upper(
                //                     Str::limit(Str::slug($paket->nama_paket, ''), 5, '')
                //                 );

                //                 $datePart = now()->format('Ymd');

                //                 // preview only
                //                 $randomPart = str_pad(random_int(1, 999), 3, '0', STR_PAD_LEFT);

                //                 return "ADW-{$paketPart}-{$customerPart}-{$datePart}-{$randomPart}";
                //             })
                //     ])
                //     ->columnSpanFull(),

                // Section::make('Payment')
                //     ->schema([
                //         TextInput::make('payment.jumlah_bayar')
                //             ->label('Jumlah Bayar')
                //             ->numeric()
                //             ->required()
                //             ->prefix('Rp.'),

                //         DatePicker::make('tanggal_bayar')
                //             ->label('Tanggal Bayar')
                //             ->default(now())
                //             ->displayFormat('l, d M Y')
                //             ->required(),


                //         Select::make('payment.metode_pembayaran')
                //             ->label('Metode Pembayaran')
                //             ->options([
                //                 'cash' => 'Cash',
                //                 'transfer' => 'Transfer',
                //                 'kartu_kredit' => 'Kartu Kredit',
                //             ])
                //             ->required(),

                //         FileUpload::make('payment.bukti_bayar')
                //             ->label('Bukti Bayar')
                //             ->disk('public')
                //             ->directory('payment-files')
                //             ->image(),
                //         // ->required(),
                //     ])
                //     ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('no')
                    ->alignCenter()
                    ->state(
                        static function (HasTable $livewire, stdClass $rowLoop): string {
                            return (string) (
                                $rowLoop->iteration +
                                ($livewire->getTableRecordsPerPage() * (
                                    $livewire->getTablePage() - 1
                                ))
                            );
                        }
                    ),
                Tables\Columns\TextColumn::make('customer_data')
                    ->label('Customer')
                    ->columnSpan(2)
                    ->html(true)
                    ->badge()
                    ->icon('heroicon-o-lock-closed')
                    ->getStateUsing(function ($record) {
                        $bookingCode = $record->booking_code;
                        $namaCustomer = $record->customer->nama_ktp;

                        $data1 = $namaCustomer;
                        $data2 = $bookingCode;  // Format date
                        // Concatenate with <br> for line breaks between the two
                        return '' . $data1 . '<br>' . '' . $data2;
                    }),
                Tables\Columns\TextColumn::make('paket_info')
                    ->label('Paket Travel')
                    ->columnSpan(2)
                    ->html(true)
                    ->badge()
                    ->getStateUsing(function ($record) {
                        $namaPaket = $record->paketUmroh->nama_paket;
                        $tglKeberangkatan = $record->jadwalKeberangkatan->tanggal_keberangkatan;

                        $data1 = $namaPaket;
                        $data2 = Carbon::parse($tglKeberangkatan)->translatedFormat('l, d M Y');  // Format date
                        // Concatenate with <br> for line breaks between the two
                        return 'Paket  : ' . $data1 . '<br>' . 'Tanggal Berangkat    : ' . $data2;
                    }),

                Tables\Columns\TextColumn::make('total_price')
                    ->badge()
                    ->color(
                        fn($state) =>
                        str_contains($state, '-') ? 'success' : 'success'
                    )
                    ->weight(FontWeight::Medium)
                    ->money('IDR'),
                Tables\Columns\TextColumn::make('sisa_tagihan')
                    ->badge()
                    ->color(
                        fn($state) =>
                        str_contains($state, '-') ? 'warning' : 'warning'
                    )
                    ->weight(FontWeight::Medium)
                    ->money('IDR'),
                Tables\Columns\TextColumn::make('metode_pembayaran')
                    ->label('Pembayaran'),
                Tables\Columns\TextColumn::make('status')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('creator.name')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->dateTime()
                    ->sortable()
                    ->formatStateUsing(function ($state) {
                        return \Carbon\Carbon::parse($state)->translatedFormat('l, d F Y');
                    }),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\ActionGroup::make([
                //     Tables\Actions\EditAction::make('update')
                //         ->label('Edit Booking')
                //         ->modalHeading('Edit Booking')
                //         ->modalWidth(MaxWidth::ThreeExtraLarge)
                //         ->form(fn(Form $form) => $this->transactionForm($form))
                //     // ->visible(static fn (Transaction $transaction) => $transaction->type->isStandard()),
                // ])

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


    // protected function generateBookingCode($user, int $paketId): string
    // {
    //     $paket = PaketUmroh::findOrFail($paketId);

    //     $customerPart = Str::upper(
    //         Str::limit(Str::slug($user->name, ''), 5, '')
    //     );

    //     $paketPart = Str::upper(
    //         Str::limit(Str::slug($paket->nama_paket, ''), 5, '')
    //     );

    //     $datePart = now()->format('Ymd');

    //     do {
    //         $randomPart = str_pad(random_int(1, 999), 3, '0', STR_PAD_LEFT);
    //         $code = "ADW-{$paketPart}-{$customerPart}-{$datePart}-{$randomPart}";
    //     } while (
    //         Booking::where('booking_code', $code)->exists()
    //     );

    //     return $code;
    // }

    // public function mount(): void
    // {
    //     // Jika pengguna sudah login, dapatkan data customer
    //     if (auth()->check()) {
    //         $customer = auth()->user()->customer;

    //         if ($customer) {
    //             $this->data['customer_id'] = $customer->id;
    //         }
    //     }

    //     // Jika data paket_id ada, sinkronkan detail paket
    //     if ($this->data['paket_id']) {
    //         $this->syncPaketDetails(
    //             $this->data['paket_id'],
    //             fn($key, $value) => data_set($this->data, $key, $value)
    //         );
    //     }

    //     // Periksa apakah kita sedang berada di halaman edit
    //     if ($this->record) {
    //         // Ambil data untuk entitas yang sedang diedit dan isikan ke form
    //         $this->data['paket_id'] = $this->record->paket_umroh_id;
    //         $this->data['jadwal_keberangkatan_id'] = $this->record->jadwal_keberangkatan_id;
    //         $this->data['booking_id'] = $this->record->booking_code;
    //         $this->data['total_price'] = $this->record->total_price;
    //         $this->data['sisa_tagihan'] = $this->record->sisa_tagihan;

    //         // Jika perlu, sinkronkan data lainnya seperti payment status, dsb.
    //         $this->data['payment_id'] = $this->record->payment ? $this->record->payment->id : null;
    //     }

    //     // Isi form dengan data yang sudah dimuat
    //     $this->form->fill($this->data);
    // }



    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\FormBooking::route('/create'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }

    // protected static function booted()
    // {
    //     static::creating(function (Booking $booking) {
    //         $booking->booking_code ??= BookingCodeGenerator::make(
    //             $booking->created_by,
    //             $booking->paket_id
    //         );
    //     });
    // }
}
