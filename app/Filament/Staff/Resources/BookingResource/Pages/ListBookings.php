<?php

namespace App\Filament\Staff\Resources\BookingResource\Pages;


use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Staff\Resources\BookingResource;

class ListBookings extends ListRecords
{
    protected static string $resource = BookingResource::class;

    protected static string $view = 'filament.staff.resources.booking-resource.pages.form-booking';

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make()
            //     ->label('Buat Booking')
        ];
    }
}
