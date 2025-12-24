<?php

namespace App\Filament\Staff\Resources;

use App\Filament\Staff\Resources\PendaftaranResource\Pages;
use App\Filament\Staff\Resources\PendaftaranResource\RelationManagers;
use App\Models\Pendaftaran;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Spatie\Permission\Traits\HasRoles;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Illuminate\Validation\Rules\Password;
use Filament\Tables\Filters\TrashedFilter;


class PendaftaranResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // public static function shouldRegisterNavigation(): bool
    // {
    //     return auth()->user()?->hasRole('staff') ?? false;
    // }

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
            Section::make('Data Customer')
                ->schema([
                    Grid::make(2)
                        ->schema([
                            TextInput::make('name')
                                ->label('Nama Lengkap')
                                ->required()
                                ->maxLength(255),

                            TextInput::make('phone')
                                ->label('No. HP / WhatsApp')
                                ->tel()
                                ->required()
                                ->maxLength(20),
                        ]),

                    TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->required()
                        ->unique(
                            table: User::class,
                            ignorable: fn ($record) => $record
                        )
                        ->maxLength(255),
                ]),

            Section::make('Keamanan Akun')
                ->schema([
                    TextInput::make('password')
                        ->label('Password')
                        ->password()
                        ->rule(Password::default())
                        ->required(fn (string $context) => $context === 'create')
                        ->dehydrated(fn ($state) => filled($state))
                        ->maxLength(255)
                        ->confirmed(),

                    TextInput::make('password_confirmation')
                        ->label('Konfirmasi Password')
                        ->password()
                        ->required(fn (string $context) => $context === 'create')
                        ->dehydrated(false),
                ]),

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
            ->columns([
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
                Tables\Actions\EditAction::make(),
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
