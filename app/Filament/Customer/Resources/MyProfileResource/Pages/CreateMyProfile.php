<?php

namespace App\Filament\Customer\Resources\MyProfileResource\Pages;

use App\Filament\Customer\Resources\MyProfileResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMyProfile extends CreateRecord
{
    protected static string $resource = MyProfileResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }
}
