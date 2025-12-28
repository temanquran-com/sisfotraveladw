<?php

namespace App\Filament\Customer\Resources\MyGalleryResource\Pages;

use App\Filament\Customer\Resources\MyGalleryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;


class CreateMyGallery extends CreateRecord
{
    protected static string $resource = MyGalleryResource::class;

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
