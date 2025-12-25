<?php

namespace App\Filament\Customer\Resources\MyTestimoniResource\Pages;

use App\Filament\Customer\Resources\MyTestimoniResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMyTestimoni extends EditRecord
{
    protected static string $resource = MyTestimoniResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
