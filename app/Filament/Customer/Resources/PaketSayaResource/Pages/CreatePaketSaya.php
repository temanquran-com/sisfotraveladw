<?php

namespace App\Filament\Customer\Resources\PaketSayaResource\Pages;

use App\Filament\Customer\Resources\PaketSayaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;


class CreatePaketSaya extends CreateRecord
{
    protected static string $resource = PaketSayaResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = auth()->id();

        return $data;
    }
}
