<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PaketSaya>
 */
class PaketSayaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory(),
            'booking_id' => Booking::factory(),
            'payment_id' => Payment::factory(),
            'created_by' => User::factory(),
        ];
    }
}
