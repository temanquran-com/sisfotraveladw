<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerDocumentResource\RelationManagers\DocumentsRelationManager;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use App\Models\Customer;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Infolists\Components\Split;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CustomerResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use RelationManagers\CustomerDocumentsRelationManager;
use App\Filament\Resources\CustomerResource\RelationManagers;


class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-heart';

    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\Select::make('user_id')
                //     ->label('Nama Customer')
                //     ->relationship('user', 'name')
                //     ->searchable()
                //     ->preload()
                //     ->default(null),
                Select::make('user_id')
                    ->label('Nama Customer')
                    ->relationship('user', 'name', function ($query) {
                        $query->where('role', 'customer');  // Filter users by role 'customer'
                    })
                    ->searchable()
                    ->preload()
                    ->default(null),
                Forms\Components\TextInput::make('no_ktp')
                 ->label('No KTP')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('no_kk')
                    ->label('No KK')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('no_passport')
                    ->label('No Passport')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('nama_ayah')
                    ->label('Nama Ayah Kandung')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('kota_passport')
                    ->label('Kota Passport')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\DatePicker::make('tgl_dikeluarkan_passport'),
                Forms\Components\DatePicker::make('tgl_habis_passport'),
                Forms\Components\TextInput::make('nama_ktp')
                    ->label('Nama di KTP')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('nama_passport')
                    ->label('Nama di Passport')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\Textarea::make('alamat')
                    ->columnSpanFull(),
                Forms\Components\DatePicker::make('tgl_lahir'),
                Forms\Components\TextInput::make('tempat_lahir')
                    ->maxLength(255)
                    ->default(null),

                Forms\Components\TextInput::make('provinsi')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('kota_kabupaten')
                    ->maxLength(255)
                    ->default(null),
                // Forms\Components\TextInput::make('kewarganegaraan')
                //     ->maxLength(255)
                //     ->default(null),
                Select::make('kewarganegaraan')
                    ->label("Kewarganegaraan")
                    ->options([
                    'indonesia' => 'Indonesia',
                    'malaysia' => 'Malaysia',
                    'singapura' => 'Singapura',
                    'australia' => 'Australia',
                    'lain' => 'Lainnya',
                    ])
                    ->default('indonesia')
                    ->required(),
                // Forms\Components\TextInput::make('status_pernikahan')
                //     ->maxLength(255)
                //     ->default(null),
                Select::make('status_pernikahan')
                    ->label("Status Pernikahan")
                    ->options([
                    'menikah' => 'Menikah',
                    'janda' => 'Janda',
                    'duda' => 'Duda',
                    'belum menikah' => 'Belum Menikah',
                    'lain' => 'Lainnya',
                    ])
                    ->default('menikah')
                    ->required(),
                // Forms\Components\TextInput::make('jenis_pendidikan')
                //     ->maxLength(255)
                //     ->default(null),
                Select::make('jenis_pendidikan')
                    ->label("Jenis Pendidikan")
                    ->options([
                    'S3' => 'S3',
                    'S2' => 'S2',
                    'S1' => 'S1',
                    'D3' => 'D3',
                    'SMA/SMK' => 'SMA/SMK',
                    'SMP' => 'SMP',
                    'SD' => 'SD',
                    'Tidak Sekolah' => 'Tidak Sekolah',

                    ])
                    ->default('S1')
                    ->required(),
                Forms\Components\TextInput::make('jenis_pekerjaan')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('metode_pembayaran')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('no_hp')
                    ->prefix('+62')
                    ->label('No Telp/HP')
                    ->maxLength(255)
                    ->default(null),
                // Forms\Components\TextInput::make('upload_ktp')
                //     ->maxLength(255)
                //     ->default(null),
                FileUpload::make('upload_ktp')
                    ->label('Upload KTP')
                    ->image() // Ensures only image files can be uploaded
                    ->disk('public') // Store files on the 'public' disk (in `storage/app/public`)
                    ->directory('customer-files') // Store images in the 'tour-leaders' folder inside the 'public' disk
                    ->maxSize(1024) // Max size in kilobytes (1MB)
                    ->enableOpen() // Allow users to open the image
                    ->columnSpanFull()
                    ->default(null), // Default value for the field
                // Forms\Components\TextInput::make('upload_kk')
                //     ->maxLength(255)
                //     ->default(null),
                FileUpload::make('upload_kk')
                    ->label('Upload KKK')
                    ->image() // Ensures only image files can be uploaded
                    ->disk('public') // Store files on the 'public' disk (in `storage/app/public`)
                    ->directory('customer-files') // Store images in the 'tour-leaders' folder inside the 'public' disk
                    ->maxSize(1024) // Max size in kilobytes (1MB)
                    ->enableOpen() // Allow users to open the image
                    ->columnSpanFull()
                    ->default(null), // Default value for the field
                // Forms\Components\TextInput::make('upload_passport')
                //     ->maxLength(255)
                //     ->default(null),
                FileUpload::make('upload_passport')
                    ->label('Upload Passport')
                    ->image() // Ensures only image files can be uploaded
                    ->disk('public') // Store files on the 'public' disk (in `storage/app/public`)
                    ->directory('customer-files') // Store images in the 'tour-leaders' folder inside the 'public' disk
                    ->maxSize(1024) // Max size in kilobytes (1MB)
                    ->enableOpen() // Allow users to open the image
                    ->columnSpanFull()
                    ->default(null), // Default value for the field
                // Forms\Components\TextInput::make('upload_photo')
                //     ->maxLength(255)
                //     ->default(null),
                FileUpload::make('upload_photo')
                    ->label('Upload Photo')
                    ->image() // Ensures only image files can be uploaded
                    ->disk('public') // Store files on the 'public' disk (in `storage/app/public`)
                    ->directory('customer-files') // Store images in the 'tour-leaders' folder inside the 'public' disk
                    ->maxSize(1024) // Max size in kilobytes (1MB)
                    ->enableOpen() // Allow users to open the image
                    ->columnSpanFull()
                    ->default(null), // Default value for the field

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama Customer')
                    ->sortable(),
                // Tables\Columns\TextColumn::make('no_ktp')
                //     ->label('NO KTP')
                //     // ->columnSpan(2)
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('no_kk')
                //     ->label('NO KK')
                //     ->searchable(),
                Tables\Columns\TextColumn::make('no_KK_and_no_KTP')
                    ->label('Data KK & KTP')
                    ->columnSpan(3)
                    ->alignLeft()
                    ->html(true)
                  ->getStateUsing(function ($record) {
                        $data1 = $record->no_ktp;  // Fetch the no_ktp value
                        $data2 = $record->no_kk;   // Fetch the no_kk value

                        // Concatenate with <br> for line break between the two
                        return 'KTP  : ' . $data1 . '<br>' . 'KK    : ' . $data2;
                    }),
                Tables\Columns\TextColumn::make('no_passport')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_ayah')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kota_passport')
                    ->searchable(),
                // Tables\Columns\TextColumn::make('tgl_dikeluarkan_passport')
                //     ->date()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('tgl_habis_passport')
                //     ->date()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('tgl_passport')
                    ->label('Tanggal Passport')
                    ->columnSpan(3)
                    ->alignRight()
                    ->html(true)
                  ->getStateUsing(function ($record) {
                          // Format the 'tgl_dikeluarkan_passport' and 'tgl_habis_passport' dates
                        $data1 = Carbon::parse($record->tgl_dikeluarkan_passport)->format('Y-m-d');  // Format the issued date
                        $data2 = Carbon::parse($record->tgl_habis_passport)->format('Y-m-d');  // Format the expiry date

                        // Concatenate with <br> for line breaks between the two
                        return 'Start  : ' . $data1 . '<br>' . 'End    : ' . $data2;
                    }),
                Tables\Columns\TextColumn::make('nama_ktp')
                    ->label('Nama KTP')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_passport')
                ->label('Nama Passport')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tgl_lahir')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tempat_lahir')
                    ->searchable(),
                Tables\Columns\TextColumn::make('provinsi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kota_kabupaten')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kewarganegaraan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status_pernikahan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jenis_pendidikan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jenis_pekerjaan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('metode_pembayaran')
                    ->searchable(),
                Tables\Columns\TextColumn::make('no_hp')
                    ->searchable(),
                Tables\Columns\TextColumn::make('upload_ktp')
                    ->searchable(),
                Tables\Columns\TextColumn::make('upload_kk')
                    ->searchable(),
                Tables\Columns\TextColumn::make('upload_passport')
                    ->searchable(),
                Tables\Columns\TextColumn::make('upload_photo')
                    ->searchable(),
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
            'documents' => DocumentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
            // 'index' => Pages\CustomerView::route('/'),
        ];
    }
}
