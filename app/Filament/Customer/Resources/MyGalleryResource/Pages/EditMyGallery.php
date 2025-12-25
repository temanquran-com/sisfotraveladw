<?php

namespace App\Filament\Customer\Resources\MyGalleryResource\Pages;

use App\Filament\Customer\Resources\MyGalleryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMyGallery extends EditRecord
{
    protected static string $resource = MyGalleryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
