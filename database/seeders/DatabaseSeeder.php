<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            CustomerSeeder::class,
            BandaraSeeder::class,
            MaskapaiSeeder::class,
            HotelMadinahSeeder::class,
            HotelMekahSeeder::class,
            TourLeaderSeeder::class,
            MuthawifSeeder::class,
            PaketUmrohSeeder::class,
            JadwalKeberangkatanSeeder::class,
            TestimoniSeeder::class,
            BookingSeeder::class,
            PaymentSeeder::class,
        ]);
    }
}
