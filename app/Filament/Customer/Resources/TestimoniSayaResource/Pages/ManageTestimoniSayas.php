<?php

namespace App\Filament\Customer\Resources\TestimoniSayaResource\Pages;

use App\Filament\Customer\Resources\TestimoniSayaResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageTestimoniSayas extends ManageRecords
{
    protected static string $resource = TestimoniSayaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
