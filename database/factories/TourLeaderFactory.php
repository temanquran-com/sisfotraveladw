<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TourLeader>
 */
class TourLeaderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_tour_leader' => $this->faker->name(),
            'nik' => $this->faker->unique()->numerify('################'),
            'no_passport' => strtoupper($this->faker->bothify('??######')),
            'nomor_visa' => strtoupper($this->faker->bothify('VISA-#####')),
            'tgl_awal_visa' => $this->faker->dateTimeBetween('now', '+2 months'),
            'tgl_akhir_visa' => $this->faker->dateTimeBetween('+2 months', '+1 year'),
            'id_karyawan' => null,
            'status' => 'aktif',
            'nomor_handphone' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'alamat' => $this->faker->address(),
            'photo_url' => $this->faker->imageUrl(),
        ];
    }
}
