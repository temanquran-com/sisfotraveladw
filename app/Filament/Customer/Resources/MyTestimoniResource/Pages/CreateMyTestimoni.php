<?php

namespace App\Filament\Customer\Resources\MyTestimoniResource\Pages;

use Carbon\Carbon;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Customer\Resources\MyTestimoniResource;

class CreateMyTestimoni extends CreateRecord
{
    protected static string $resource = MyTestimoniResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['last_update'] = Carbon::now();
        $data['user_id'] = auth()->id();

        return $data;
    }

}
