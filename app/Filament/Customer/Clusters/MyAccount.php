<?php

namespace App\Filament\Customer\Clusters;

use Filament\Clusters\Cluster;
use Filament\Facades\Filament;


class MyAccount extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    public static function canAccess(): bool
    {
        return Filament::getCurrentPanel()?->getId() === 'customer';
    }
}
