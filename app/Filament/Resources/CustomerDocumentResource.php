<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\CustomerDocument;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CustomerDocumentResource\Pages;
use App\Filament\Resources\CustomerDocumentResource\RelationManagers;
use App\Filament\Resources\CustomerDocumentResource\RelationManagers\DocumentsRelationManager;
use Filament\Facades\Filament;

class CustomerDocumentResource extends Resource
{
    protected static ?string $model = CustomerDocument::class;

    // protected static ?string $navigationGroup = "Kelola Customer";

    // protected static ?int $navigationSort = 2;

    //default hide
    public static function shouldRegisterNavigation(): bool
    {
        return Filament::getCurrentPanel()?->getId() === 'staff';
    }

    protected static ?string $navigationIcon = 'heroicon-o-archive-box-arrow-down';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
               Select::make('user_id')
                    ->label('Nama Customer')
                    ->relationship('user', 'name', function ($query) {
                        $query->where('role', 'customer');  // Filter users by role 'customer'
                    })
                    ->searchable()
                    ->preload()
                    ->default(null),
                Forms\Components\TextInput::make('document_type')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('document_number')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('issued_city')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\DatePicker::make('issued_at'),
                Forms\Components\DatePicker::make('expired_at'),
                Forms\Components\TextInput::make('file_path')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer.user.name')
                    ->label('Nama Customer')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('document_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('document_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('issued_city')
                    ->searchable(),
                Tables\Columns\TextColumn::make('issued_at')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('expired_at')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('file_path')
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
            'index' => Pages\ListCustomerDocuments::route('/'),
            'create' => Pages\CreateCustomerDocument::route('/create'),
            'edit' => Pages\EditCustomerDocument::route('/{record}/edit'),
        ];
    }
}
