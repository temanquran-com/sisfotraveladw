<?php

namespace Database\Seeders;

use App\Models\Maskapai;
use Illuminate\Database\Seeder;

class MaskapaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Maskapai::factory(5)->create();

         $maskapaiList = [
            [
                'nama_maskapai' => 'Garuda Indonesia',
                'kode_iata' => 'GA',
                'kode_icao' => 'GIA',
                'logo' => 'logos/garuda.png',
            ],
            [
                'nama_maskapai' => 'Citilink',
                'kode_iata' => 'QG',
                'kode_icao' => 'CTV',
                'logo' => 'logos/citilink.png',
            ],
            [
                'nama_maskapai' => 'Lion Air',
                'kode_iata' => 'JT',
                'kode_icao' => 'LNI',
                'logo' => 'logos/lion.png',
            ],
            [
                'nama_maskapai' => 'Batik Air',
                'kode_iata' => 'ID',
                'kode_icao' => 'BTK',
                'logo' => 'logos/batikair.png',
            ],
            [
                'nama_maskapai' => 'Super Air Jet',
                'kode_iata' => 'IU',
                'kode_icao' => 'SJV',
                'logo' => 'logos/superairjet.png',
            ],
            [
                'nama_maskapai' => 'Sriwijaya Air',
                'kode_iata' => 'SJ',
                'kode_icao' => 'SJY',
                'logo' => 'logos/sriwijaya.png',
            ],
            [
                'nama_maskapai' => 'NAM Air',
                'kode_iata' => 'IN',
                'kode_icao' => 'NIH',
                'logo' => 'logos/namair.png',
            ],
            [
                'nama_maskapai' => 'Pelita Air',
                'kode_iata' => 'IP',
                'kode_icao' => 'PAS',
                'logo' => 'logos/pelita.png',
            ],
            [
                'nama_maskapai' => 'Wings Air',
                'kode_iata' => 'IW',
                'kode_icao' => 'WON',
                'logo' => 'logos/wingsair.png',
            ],
            [
                'nama_maskapai' => 'TransNusa',
                'kode_iata' => '8B',
                'kode_icao' => 'TNU',
                'logo' => 'logos/transnusa.png',
            ],
        ];

        foreach ($maskapaiList as $maskapai) {
            Maskapai::updateOrCreate(
                ['kode_iata' => $maskapai['kode_iata']],
                $maskapai
            );
        }

    }
}
