<?php

namespace Database\Seeders;

use App\Models\Bandara;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BandaraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Optional: bandara besar Indonesia
        Bandara::create([
            'kode_bandara' => 'CGK',
            'nama_bandara' => 'Soekarno-Hatta International Airport',
            'kota_bandara' => 'Jakarta'
        ]);

        Bandara::create([
            'kode_bandara' => 'SUB',
            'nama_bandara' => 'Juanda International Airport',
            'kota_bandara' => 'Surabaya'
        ]);

             // Optional: bandara besar Indonesia
        Bandara::create([
            'kode_bandara' => 'SSQ',
            'nama_bandara' => 'Sultan Syarif Qosim II',
            'kota_bandara' => 'Pekanbaru'
        ]);

        Bandara::create([
            'kode_bandara' => 'KNO',
            'nama_bandara' => 'Kualanamu International Airport',
            'kota_bandara' => 'Medan'
        ]);
    }
}
