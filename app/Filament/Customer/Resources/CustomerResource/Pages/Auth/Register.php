<?php

namespace App\Filament\Customer\Resources\CustomerResource\Pages\Auth;

use App\Filament\Customer\Resources\CustomerResource;
use Filament\Pages\Auth\Register as BaseRegister;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Component;

class Register extends BaseRegister
{
    // protected static string $resource = CustomerResource::class;

    // protected static string $view = 'filament.customer.resources.customer-resource.pages.auth.register';
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getPhoneFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                        // $this->getRoleFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    protected function getRoleFormComponent(): Component
    {
        return Select::make('role')
            ->options([
                'customer' => 'Customer',
                'staff' => 'Staff',
            ])
            ->default('customer')
            ->required();
    }

    protected function getPhoneFormComponent(): Component
    {
        return TextInput::make('phone')
            ->label('Nomor Telepon')
            ->tel()
            ->required();
    }
}
