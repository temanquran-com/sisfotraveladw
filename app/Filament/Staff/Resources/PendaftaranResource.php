<?php

namespace App\Filament\Staff\Resources;

use stdClass;
use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Pendaftaran;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Spatie\Permission\Traits\HasRoles;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rules\Password;
use Filament\Tables\Filters\TrashedFilter;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Staff\Resources\PendaftaranResource\Pages;
use App\Filament\Staff\Resources\PendaftaranResource\RelationManagers;

class PendaftaranResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationGroup = "Kelola Customer";

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    // public static function shouldRegisterNavigation(): bool
    // {
    //     return auth()->user()?->hasRole('staff') ?? false;
    // }

    public static function getNavigationBadge(): ?string
    {
         return static::getModel()
             ::where('role', 'customer')
            ->count();
    }

    public function canAccessPanel(User $user): bool
    {
        return $user->hasRole('staff');
    }

    public static function getLabel(): string
    {
        return 'Pendaftaran';
    }

    public static function getSlug(): string
    {
        return 'pendaftaran';
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Registrasi Sistem')
                    ->collapsible()
                    ->schema([
                        Grid::make()
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nama Lengkap')
                                    ->required()
                                    ->columnSpanFull()
                                    ->maxLength(255),

                                TextInput::make('phone')
                                    ->label('No. HP / WhatsApp')
                                    ->tel()
                                    ->required()
                                    ->maxLength(20),

                                TextInput::make('email')
                                    ->label('Email')
                                    ->email()
                                    ->required()
                                    ->unique(
                                        table: User::class,
                                        ignorable: fn($record) => $record
                                    )
                                    ->maxLength(255),
                            ]),

                        Card::make([
                            TextInput::make('password')
                                ->label('Password')
                                ->password()
                                ->rule(Password::default())
                                ->required(fn(string $context) => $context === 'create')
                                ->dehydrated(fn($state) => filled($state))
                                ->maxLength(255)
                                ->confirmed(),

                            TextInput::make('password_confirmation')
                                ->label('Konfirmasi Password')
                                ->password()
                                ->required(fn(string $context) => $context === 'create')
                                ->dehydrated(false),
                        ])
                    ]),

                // Section::make('Data Profile')
                //     ->collapsible()
                //     ->collapsed(true)
                //     ->schema([
                //         Grid::make(2)->schema([
                //             TextInput::make('nama_ktp')->required(),
                //             TextInput::make('nama_passport'),
                //             TextInput::make('no_ktp')->numeric(),
                //             TextInput::make('no_kk')->numeric(),
                //             DatePicker::make('tgl_lahir'),
                //             TextInput::make('tempat_lahir'),
                //             TextInput::make('nama_ayah'),
                //             TextInput::make('no_hp')->prefix('+62'),
                //         ]),
                //         Textarea::make('alamat')->columnSpanFull(),
                //     ]),

                // Section::make('Data Passport')
                //     ->collapsible()
                //     ->collapsed(true)
                //     ->schema([
                //         Grid::make(2)->schema([
                //             TextInput::make('no_passport'),
                //             // ->default(fn() => $this->record?->no_passport),
                //             TextInput::make('kota_passport'),
                //             // ->default(fn() => $this->record?->kota_passport),
                //             DatePicker::make('tgl_dikeluarkan_passport'),
                //             // ->default(fn() => $this->record?->tgl_dikeluarkan_passport),
                //             DatePicker::make('tgl_habis_passport'),
                //             // ->default(fn() => $this->record?->tgl_habis_passport),
                //         ]),
                //     ]),

                // Section::make('Data Tambahan')
                //     ->collapsible()
                //     ->collapsed(true)
                //     ->schema([
                //         Grid::make(2)->schema([
                //             Select::make('provinsi')
                //                 ->label('Provinsi')
                //                 ->options([
                //                     'Aceh' => 'Aceh',
                //                     'Sumatera Utara' => 'Sumatera Utara',
                //                     'Sumatera Barat' => 'Sumatera Barat',
                //                     'Riau' => 'Riau',
                //                     'Kepulauan Riau' => 'Kepulauan Riau',
                //                     'Jambi' => 'Jambi',
                //                     'Sumatera Selatan' => 'Sumatera Selatan',
                //                     'Bangka Belitung' => 'Kepulauan Bangka Belitung',
                //                     'Bengkulu' => 'Bengkulu',
                //                     'Lampung' => 'Lampung',
                //                     'DKI Jakarta' => 'DKI Jakarta',
                //                     'Jawa Barat' => 'Jawa Barat',
                //                     'Jawa Tengah' => 'Jawa Tengah',
                //                     'DI Yogyakarta' => 'DI Yogyakarta',
                //                     'Jawa Timur' => 'Jawa Timur',
                //                     'Banten' => 'Banten',
                //                     'Bali' => 'Bali',
                //                     'Nusa Tenggara Barat' => 'Nusa Tenggara Barat',
                //                     'Nusa Tenggara Timur' => 'Nusa Tenggara Timur',
                //                     'Kalimantan Barat' => 'Kalimantan Barat',
                //                     'Kalimantan Tengah' => 'Kalimantan Tengah',
                //                     'Kalimantan Selatan' => 'Kalimantan Selatan',
                //                     'Kalimantan Timur' => 'Kalimantan Timur',
                //                     'Kalimantan Utara' => 'Kalimantan Utara',
                //                     'Sulawesi Utara' => 'Sulawesi Utara',
                //                     'Sulawesi Tengah' => 'Sulawesi Tengah',
                //                     'Sulawesi Selatan' => 'Sulawesi Selatan',
                //                     'Sulawesi Tenggara' => 'Sulawesi Tenggara',
                //                     'Gorontalo' => 'Gorontalo',
                //                     'Sulawesi Barat' => 'Sulawesi Barat',
                //                     'Maluku' => 'Maluku',
                //                     'Maluku Utara' => 'Maluku Utara',
                //                     'Papua' => 'Papua',
                //                     'Papua Barat' => 'Papua Barat',
                //                     'Papua Selatan' => 'Papua Selatan',
                //                     'Papua Tengah' => 'Papua Tengah',
                //                     'Papua Pegunungan' => 'Papua Pegunungan',
                //                     'Papua Barat Daya' => 'Papua Barat Daya',
                //                 ])
                //                 ->searchable()
                //                 ->required(),
                //             TextInput::make('kota_kabupaten'),
                //             Select::make('kewarganegaraan')
                //                 ->label('Kewarganegaraan')
                //                 ->options([
                //                     'Indonesia' => 'Indonesia',
                //                     'Malaysia' => 'Malaysia',
                //                     'Singapura' => 'Singapura',
                //                     'Brunei' => 'Brunei Darussalam',
                //                     'Thailand' => 'Thailand',
                //                     'Lainnya' => 'Lainnya',
                //                 ])
                //                 ->searchable()
                //                 ->default('Indonesia'),
                //             // ->default(fn () => $this->record?->kewarganegaraan)
                //             Select::make('status_pernikahan')
                //                 ->label('Status Pernikahan')
                //                 ->options([
                //                     'Belum Menikah' => 'Belum Menikah',
                //                     'Menikah' => 'Menikah',
                //                     'Cerai Hidup' => 'Cerai Hidup',
                //                     'Cerai Mati' => 'Cerai Mati',
                //                 ])
                //                 ->placeholder('Pilih status'),
                //             Select::make('jenis_pendidikan')
                //                 ->label('Pendidikan Terakhir')
                //                 ->options([
                //                     'SD' => 'SD',
                //                     'SMP' => 'SMP',
                //                     'SMA' => 'SMA / SMK',
                //                     'D3' => 'D3',
                //                     'S1' => 'S1',
                //                     'S2' => 'S2',
                //                     'S3' => 'S3',
                //                     'Lainnya' => 'Lainnya',
                //                 ])
                //                 ->searchable(),
                //             Select::make('jenis_pekerjaan')
                //                 ->label('Pekerjaan')
                //                 ->options([
                //                     'Pelajar/Mahasiswa' => 'Pelajar / Mahasiswa',
                //                     'Karyawan Swasta' => 'Karyawan Swasta',
                //                     'PNS' => 'PNS',
                //                     'Wiraswasta' => 'Wiraswasta',
                //                     'Ibu Rumah Tangga' => 'Ibu Rumah Tangga',
                //                     'Pensiunan' => 'Pensiunan',
                //                     'Lainnya' => 'Lainnya',
                //                 ])
                //                 ->searchable(),
                //         ]),
                //     ]),


                /**
                 * Hidden field
                 * Role selalu customer
                 */
                Hidden::make('role')
                    ->default('customer'),
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
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Customer')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('No HP.')
                    ->searchable()
                    ->sortable(),
                // Tables\Columns\TextColumn::make('role')
                //     ->label(__('filament.users.role'))
                //     ->badge()
                //     ->sortable(),
                // ->formatStateUsing(function (string $state): string {
                //     $role = UserRoles::from($state);

                //     return $role->getLabel() ?? $state;
                // }),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),       // soft delete
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    /**
     * 📌 Query hanya customer
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ])
            ->where('role', 'customer');
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
            'index' => Pages\ListPendaftarans::route('/'),
            'create' => Pages\CreatePendaftaran::route('/create'),
            'edit' => Pages\EditPendaftaran::route('/{record}/edit'),
        ];
    }
}
