<?php

namespace App\Filament\Resources\BandaraResource\Pages;

use App\Filament\Resources\BandaraResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBandara extends CreateRecord
{
    protected static string $resource = BandaraResource::class;

        protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
