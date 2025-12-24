<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{

      protected $model = Payment::class;


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'booking_id' => Booking::inRandomOrder()->value('id') ?? Booking::factory(),
            // 'verified_by' => $this->faker->randomElement([
            //     null,
            //     User::inRandomOrder()->value('id') ?? User::factory()
            // ]),

            'verified_by' => 1,

            'jumlah_bayar' => $this->faker->randomElement([5000000, 7000000, 10000000, 15000000]),
            'tanggal_bayar' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),

            'metode_pembayaran' => $this->faker->randomElement(['cash', 'transfer']),

            'bukti_bayar' => $this->faker->randomElement([
                null,
                'uploads/payments/' . $this->faker->uuid . '.jpg'
            ]),

            'status' => $this->faker->randomElement(['pending', 'verified', 'rejected']),
            'created_by' => User::inRandomOrder()->first()->id ?? User::factory(),

        ];
    }
}
