<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\PaketUmroh;
use Illuminate\Database\Seeder;
use App\Models\JadwalKeberangkatan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
           // Pastikan data relasi tersedia
        if (User::count() == 0) {
            User::factory()->count(5)->create();
        }

        if (Customer::count() == 0) {
            Customer::factory()->count(10)->create();
        }

        if (PaketUmroh::count() == 0) {
            PaketUmroh::factory()->count(5)->create();
        }

        if (JadwalKeberangkatan::count() == 0) {
            JadwalKeberangkatan::factory()->count(5)->create();
        }

        // Generate 20 booking dummy
        Booking::factory()->count(20)->create();
    }
}
