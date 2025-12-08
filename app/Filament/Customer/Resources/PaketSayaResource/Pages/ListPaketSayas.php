<?php

namespace App\Filament\Customer\Resources\PaketSayaResource\Pages;

use App\Filament\Customer\Resources\PaketSayaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPaketSayas extends ListRecords
{
    protected static string $resource = PaketSayaResource::class;

    protected static string $view = 'filament.customer.resources.paket-saya-resource.pages.paket-saya';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('Pilih Paket'),
        ];
    }


}
