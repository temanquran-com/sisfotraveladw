<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Payment;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PaymentResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PaymentResource\RelationManagers;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('booking.')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('verified_by')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('jumlah_bayar')
                    ->required()
                    ->numeric()
                    ->default(0.00),
                Forms\Components\DatePicker::make('tanggal_bayar')
                    ->required(),
                // Forms\Components\TextInput::make('metode_pembayaran')
                //     ->required(),
                Select::make('metode_pembayaran')
                    ->label("Metode Pembayaran")
                    ->options([
                    'cash' => 'Cash',
                    'transfer' => 'Transfer',
                    'kartu_kredit' => 'Kartu Kredit',
                    ])
                    ->default('cash')
                    ->required(),
                // Forms\Components\TextInput::make('status')
                //     ->required(),
                Select::make('status')
                    ->label("Status")
                    ->options([
                    'verified' => 'Verified',
                    'pending' => 'Pending',
                    'rejected' => 'rejected',
                    ])
                    ->default('verified')
                    ->required(),
                // Forms\Components\TextInput::make('bukti_bayar')
                //     ->maxLength(255)
                //     ->default(null),
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
                Tables\Columns\TextColumn::make('booking_id')
                    ->numeric()
                    ->sortable(),
                // Tables\Columns\TextColumn::make('verifier')
                //     ->sortable(),
                Tables\Columns\TextColumn::make('verifier.name')
                    ->label('Verifier')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jumlah_bayar')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_bayar')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('metode_pembayaran'),
                // Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->alignCenter()
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'verified' => 'success',
                        'pending' => 'warning',
                        'rejected' => 'danger',
                    }),
                // Tables\Columns\TextColumn::make('bukti_bayar')
                //     ->searchable(),
                Tables\Columns\TextColumn::make('bukti_bayar')
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
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}
