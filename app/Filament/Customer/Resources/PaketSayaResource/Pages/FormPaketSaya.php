<?php

namespace App\Filament\Customer\Resources\PaketSayaResource\Pages;

use App\Models\PaketSaya;
use App\Models\PaketUmroh;
use Filament\Resources\Pages\Page;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use App\Filament\Customer\Resources\PaketSayaResource;

class FormPaketSaya extends Page implements HasForms
{
    // Associating this page with the corresponding resource
    protected static string $resource = PaketSayaResource::class;

    // Path to the view of this page
    protected static string $view = 'filament.customer.resources.paket-saya-resource.pages.form-paket-saya';

    // Form handling and state management
    use InteractsWithForms;

    // Properties to store form data and selected values
    public $pakets = [];
    public $paket_id;
    public $booking_id;
    public $payment_id;
    public $paketDetails;

    public ?array $data = [
        'paket_id' => null,
        'nama_paket' => null,
        'booking_id' => null,
        'payment_id' => null,
        'paket_details' => [
            'harga_paket' => null,
            'durasi_hari' => null,
            'include' => null,
            'exclude' => null,
            'booking_id' => null,
        ],
    ];

    // Mount method to initialize values before form is rendered
    public function mount(): void
    {
        // Fill the form with existing data or defaults
        $this->form->fill($this->data);
    }

    // Define the schema for the form
    public function getFormSchema(): array
    {
        return [
            Card::make()->schema([
                Select::make('paket_id')
                    ->label('Pilih Paket Umroh')
                    ->options(PaketUmroh::query()->pluck('nama_paket', 'id'))
                    ->live() // Make it reactive
                    ->afterStateUpdated(function ($state, callable $set) {
                        // Sync package details when a new paket_id is selected
                        $this->syncPaketDetails($state, $set);
                    }),

                // Displaying Paket Nama and its details
                TextInput::make('nama_paket')
                    ->label('Nama Paket')
                    ->disabled() // Disable editing
                    ->dehydrated(false), // Don't hydrate this field

                // Nested fields showing Paket details
                TextInput::make('paket_details.harga_paket')
                    ->label('Harga Paket')
                    ->disabled()
                    ->dehydrated(false),

                TextInput::make('paket_details.durasi_hari')
                    ->label('Durasi Hari')
                    ->disabled()
                    ->dehydrated(false),

                TextInput::make('paket_details.include')
                    ->label('Include')
                    ->disabled()
                    ->dehydrated(false),

                TextInput::make('paket_details.exclude')
                    ->label('Exclude')
                    ->disabled()
                    ->dehydrated(false),
            ])
            ->statePath('data') // Bind all fields to $this->data
        ];
    }

    /**
     * Synchronize Paket Details with the selected PaketUmroh.
     *
     * @param int|null $paketId
     * @param callable $set
     * @return void
     */
    protected function syncPaketDetails($paketId, callable $set)
    {
        // Fetch PaketUmroh details based on selected paket_id
        $paket = PaketUmroh::find($paketId);

        // Set the related fields if paket is found
        if ($paket) {
            $set('nama_paket', $paket->nama_paket);
            $set('paket_details.harga_paket', $paket->harga_paket);
            $set('paket_details.durasi_hari', $paket->durasi_hari);
            $set('paket_details.include', $paket->include);
            $set('paket_details.exclude', $paket->exclude);
        }
    }

    // Method to handle saving the form data
    public function save()
    {
        // Ensure necessary fields are set before saving
        $this->validateBookingId();  // Validate if booking_id is set

        // Save the data to the PaketSaya model
        $paketSaya = PaketSaya::create([
            'customer_id' => 2,
            'paket_id' => $this->paket_id,
            'booking_id' => 31,
            'payment_id' => 1,
            'created_by' => auth()->id(),
        ]);

        // Flash message to confirm successful save
        session()->flash('message', 'Paket has been successfully saved!');
    }

    /**
     * Validate that the booking_id is set and valid.
     *
     * @return void
     */
    protected function validateBookingId()
    {
        if (empty($this->booking_id)) {
            session()->flash('error', 'Booking ID is required');
            return;
        }
    }
}
