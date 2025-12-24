<?php

namespace App\Filament\Staff\Resources\PendaftaranResource\Pages;

use App\Filament\Staff\Resources\PendaftaranResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePendaftaran extends CreateRecord
{
    protected static string $resource = PendaftaranResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['password'] = bcrypt($data['password']);

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
