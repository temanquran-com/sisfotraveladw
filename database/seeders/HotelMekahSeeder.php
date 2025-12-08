<?php

namespace Database\Seeders;

use App\Models\HotelMekah;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class HotelMekahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            // Generate 10 sample hotel data
        HotelMekah::factory()->count(10)->create();

        // Optional: create a high-quality sample hotel
        HotelMekah::create([
            'nama_hotel' => 'Mekah Grand ZamZam Tower',
            'bintang_hotel' => 5,
            'tarif_hotel_double_room' => 2500000,
            'tarif_hotel_triple_room' => 2000000,
            'tarif_hotel_suite_room' => 5500000,
            'contact_sales_hotel' => '+966 55 789 4321',
        ]);
    }
}
