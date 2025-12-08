<?php

namespace Database\Seeders;

use App\Models\JadwalKeberangkatan;
use Illuminate\Database\Seeder;

class JadwalKeberangkatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JadwalKeberangkatan::factory(15)->create();

    }
}


//  // memastikan semua relasi tersedia
//         PaketUmroh::factory()->count(5)->createIfEmpty();
//         TourLeader::factory()->count(5)->createIfEmpty();
//         Muthawif::factory()->count(5)->createIfEmpty();
//         Maskapai::factory()->count(3)->createIfEmpty();
//         Bandara::factory()->count(3)->createIfEmpty();

//         // generate jadwal
//         JadwalKeberangkatan::factory()->count(20)->create();

//                     // Pastikan ada minimal 1 paket
//         $paket = PaketUmroh::first();
//         if (! $paket) {
//             $paket = PaketUmroh::factory()->create();
//         }

//         // Generate jadwal keberangkatan
//         JadwalKeberangkatan::factory()
//             ->count(5)
//             ->create([
//                 'paket_umroh_id' => $paket->id,
//             ]);
