<?php

namespace Database\Factories;

use App\Models\Maskapai;
use App\Models\HotelMekah;
use App\Models\HotelMadinah;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PaketUmroh>
 */
class PaketUmrohFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
          // tanggal acak
        $start = $this->faker->dateTimeBetween('+1 week', '+2 months');
        $end   = (clone $start)->modify('+10 days'); // durasi default 10 hari

        return [
            'nama_paket' => 'Paket Umroh ' . $this->faker->word(),
            'deskripsi' => $this->faker->paragraph(),
            'durasi_hari' => $this->faker->numberBetween(9, 15),
            'durasi_hari' => $this->faker->numberBetween(15, 25),
            'harga_paket' => $this->faker->randomElement([
                24000000, 27000000, 36000000, 46000000, 54000000,
            ]),

            // relasi otomatis
            'hotel_mekah_id' => HotelMekah::inRandomOrder()->first()->id ?? HotelMekah::factory(),
            'hotel_madinah_id' => HotelMadinah::inRandomOrder()->first()->id ?? HotelMadinah::factory(),
            'maskapai_id' => Maskapai::inRandomOrder()->first()->id ?? Maskapai::factory(),

            'tanggal_start' => $start,
            'tanggal_end' => $end,
            'include' => json_encode(['Visa', 'Hotel', 'Transport', 'Makan 3x']),
            'exclude' => json_encode(['Laundry', 'Extra Koper', 'Pengeluaran Pribadi']),
            'syarat' => json_encode(['Minimal 1x vaksin', 'Foto KTP', 'Foto KK', 'Foto Pasport']),
            'thumbnail' => $this->faker->imageUrl(400, 300, 'travel'),
            'is_active' => $this->faker->boolean(90), // 90% aktif

        ];
    }
}
