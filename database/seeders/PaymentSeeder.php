<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Safety: pastikan booking ada
        if (Booking::count() == 0) {
            Booking::factory()->count(10)->create();
        }

        // Safety: pastikan user ada untuk verified_by
        if (User::count() == 0) {
            User::factory()->count(5)->create();
        }

        // Generate 30 payment dummy
        Payment::factory()->count(30)->create();
    }
}
