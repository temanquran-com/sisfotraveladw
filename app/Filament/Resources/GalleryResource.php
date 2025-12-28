<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Gallery;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\GalleryResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\GalleryResource\RelationManagers;


class GalleryResource extends Resource
{
    protected static ?string $model = Gallery::class;

    protected static ?string $navigationGroup = "Gallery & Testimoni";

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\TextInput::make('link_gambar')
                //     ->required()
                //     ->maxLength(255),
                // Forms\Components\Textarea::make('deskripsi')
                //     ->required()
                //     ->columnSpanFull(),
                RichEditor::make('deskripsi')
                    ->required()
                    ->columnSpanFull(),
                FileUpload::make('link_gambar')
                    ->label('Gambar Gallery')
                    ->image() // Ensures only image files can be uploaded
                    ->disk('public') // Store files on the 'public' disk (in `storage/app/public`)
                    ->directory('gallery-files') // Store images in the 'tour-leaders' folder inside the 'public' disk
                    ->maxSize(1024) // Max size in kilobytes (1MB)
                    ->enableOpen() // Allow users to open the image
                    ->columnSpanFull()
                    ->default(null), // Default value for the field

                Forms\Components\TextInput::make('upload_by')
                    ->default('Administrator')
                    ->readOnly()
                    ->required()
                    ->maxLength(255),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\TextColumn::make('link_gambar')
                //     ->searchable(),
                ImageColumn::make('link_gambar'),
                // Tables\Columns\TextColumn::make('link_gambar')
                //     ->label('Foto')
                //     ->icon('heroicon-m-photo')
                //     ->tooltip(function ($record) {
                //         return $record->bukti_bayar !== '-'
                //             ? 'Klik untuk melihat foto'
                //             : 'Foto tidak tersedia';
                //     })
                //     ->url(function ($record) {
                //         return $record->photo_url !== '-'
                //             ? asset('storage/' . $record->bukti_bayar)
                //             : null;
                //     })
                //     ->getStateUsing(function ($record) {
                //         return $record->bukti_bayar !== '-'
                //             ? 'Image'
                //             : '';
                //     }),
                Tables\Columns\TextColumn::make('deskripsi')
                    ->wrap(),
                Tables\Columns\TextColumn::make('upload_by')
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGalleries::route('/'),
            'create' => Pages\CreateGallery::route('/create'),
            'edit' => Pages\EditGallery::route('/{record}/edit'),
        ];
    }
}
