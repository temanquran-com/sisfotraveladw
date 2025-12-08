<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class HotelMekahFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_hotel' => $this->faker->company . ' Mekah Hotel',
            'bintang_hotel' => $this->faker->numberBetween(3, 5),
            'tarif_hotel_double_room' => $this->faker->numberBetween(600000, 3000000),
            'tarif_hotel_triple_room' => $this->faker->numberBetween(500000, 2500000),
            'tarif_hotel_suite_room' => $this->faker->numberBetween(1500000, 6000000),
            'contact_sales_hotel' => $this->faker->phoneNumber,
        ];
    }
}
