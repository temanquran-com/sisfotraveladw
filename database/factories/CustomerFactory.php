<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),

            'no_ktp' => $this->faker->numerify('################'),
            'no_kk' => $this->faker->numerify('################'),
            'no_passport' => strtoupper($this->faker->bothify('??######')),

            'nama_ayah' => $this->faker->name('male'),
            'kota_passport' => $this->faker->city(),
            'tgl_dikeluarkan_passport' => $this->faker->dateTimeBetween('now', '+2 months'),
            'tgl_habis_passport' => $this->faker->dateTimeBetween('+2 months', '+1 year'),

            'nama_ktp' => $this->faker->name(),
            'nama_passport' => $this->faker->name(),
            'alamat' => $this->faker->address(),

            'tgl_lahir' => $this->faker->date(),
            'tempat_lahir' => $this->faker->city(),
            'provinsi' => $this->faker->state(),
            'kota_kabupaten' => $this->faker->city(),
            'kewarganegaraan' => 'Indonesia',

            'status_pernikahan' => 'Belum Menikah',
            'jenis_pendidikan' => 'S1',
            'jenis_pekerjaan' => 'Karyawan Swasta',

            'metode_pembayaran' => 'cicilan',
            'no_hp' => $this->faker->phoneNumber(),

            'upload_ktp' => null,
            'upload_kk' => null,
            'upload_passport' => null,
            'upload_photo' => null,
        ];
    }
}
