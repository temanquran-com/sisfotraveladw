<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use Filament\Resources\Pages\Page;

class CustomerView extends Page
{
    protected static string $resource = CustomerResource::class;
    
    protected static ?string $navigationIcon = 'heroicon-o-archive-box-arrow-down';

    protected static string $view = 'filament.resources.customer-resource.pages.customer-view';


}
