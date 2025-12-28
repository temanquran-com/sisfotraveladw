<?php

namespace App\Filament\Customer\Resources\CustomerResource\Pages\Auth;

use App\Models\User;
use App\Models\Customer;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Auth\Register as BaseRegister;
use App\Filament\Customer\Resources\CustomerResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Register extends BaseRegister
{
    // protected static string $resource = CustomerResource::class;

    // protected static string $view = 'filament.customer.resources.customer-resource.pages.auth.register';

    protected function handleRegistration(array $data): Model
    {
        return DB::transaction(function () use ($data) {

            /** 1. Create User */
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'password' => bcrypt($data['password']),
            ]);

            /** 2. Create Customer (auto populate) */
            $user->customer()->create([
                'nama_ktp' => $data['name'],
                'email' => $data['email'],
                // field lain default
            ]);

            return $user;
        });
    }

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

    // protected function createUser(array $data): User
    // {
    //     $user = User::create([
    //         'name'     => $data['name'],
    //         'email'    => $data['email'],
    //         'password' => bcrypt($data['password']),
    //         'phone'    => $data['phone'],
    //         'role'     => 'customer',
    //     ]);



    //     Customer::firstOrCreate(
    //         ['user_id' => $user->id],
    //         ['no_hp' => $data['phone']]
    //     );

    //     return $user;
    // }


    protected function afterCreate(): void
    {
        // kirim notifikasi, welcome email, dll
    }
}
