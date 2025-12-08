<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Maskapai>
 */
class MaskapaiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_maskapai' => $this->faker->company(),
            'kode_iata' => strtoupper($this->faker->lexify('??')),
            'kode_icao' => strtoupper($this->faker->lexify('??')),
            'logo' => $this->faker->imageUrl(),
        ];
    }
}
