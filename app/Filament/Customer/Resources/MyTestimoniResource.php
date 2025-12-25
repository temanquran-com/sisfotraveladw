<?php

namespace App\Filament\Customer\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Testimoni;
use Filament\Tables\Table;
use App\Models\MyTestimoni;
use Filament\Facades\Filament;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Customer\Resources\MyTestimoniResource\Pages;
use App\Filament\Customer\Resources\MyTestimoniResource\RelationManagers;

class MyTestimoniResource extends Resource
{
    protected static ?string $model = Testimoni::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?int $navigationSort = 4;

    protected static ?string $label = 'Testimoni Saya';

    protected static ?string $navigationLabel = 'Testimoni Saya';

    protected static ?string $title = 'Testimoni Saya';

    protected static ?string $slug = 'testimoni-saya';

    public static function canAccess(): bool
    {
        return Filament::getCurrentPanel()?->getId() === 'customer';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListMyTestimonis::route('/'),
            'create' => Pages\CreateMyTestimoni::route('/create'),
            'edit' => Pages\EditMyTestimoni::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
