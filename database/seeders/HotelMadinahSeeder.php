<?php

namespace Database\Seeders;

use App\Models\HotelMadinah;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class HotelMadinahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Generate 10 sample data hotels
        HotelMadinah::factory()->count(10)->create();

        // Optional: create specific hotel data
        HotelMadinah::create([
            'nama_hotel' => 'Madinah Royal Palace',
            'bintang_hotel' => 5,
            'tarif_hotel_double_room' => 1800000,
            'tarif_hotel_triple_room' => 1500000,
            'tarif_hotel_suite_room' => 3500000,
            'contact_sales_hotel' => '+966 50 123 4567',
        ]);
    }
}
