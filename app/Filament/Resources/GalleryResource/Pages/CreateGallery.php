<?php

namespace App\Filament\Resources\GalleryResource\Pages;

use Carbon\Carbon;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\GalleryResource;

class CreateGallery extends CreateRecord
{
    protected static string $resource = GalleryResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['upload_by'] = auth()->user?->name();
        $data['user_id'] = auth()->id();

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

}
