<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\PaketUmroh;
use App\Models\TourLeader;
use App\Models\Muthawif;
use App\Models\Maskapai;
use App\Models\Bandara;
use App\Models\JadwalKeberangkatan;
use Carbon\Carbon;

class JadwalKeberangkatanFactory extends Factory
{
    protected $model = JadwalKeberangkatan::class;

    public function definition()
    {
        // tanggal keberangkatan 30–180 hari ke depan
        $tanggalKeberangkatan = $this->faker->dateTimeBetween('+30 days', '+180 days');
        $tanggalKembali = (clone $tanggalKeberangkatan)->modify('+12 days');

        $quota = $this->faker->numberBetween(20, 50);

        $tourLeader = TourLeader::inRandomOrder()->first();
        $muthawif = Muthawif::inRandomOrder()->first();
        $maskapai = Maskapai::inRandomOrder()->first();
        $bandara  = Bandara::inRandomOrder()->first();

        return [
            'paket_umroh_id' => PaketUmroh::inRandomOrder()->value('id'),

            // TOUR LEADER
            'tour_leader_id' => $tourLeader?->id,
            // 'tour_leader_name' => $tourLeader?->nama ?? null,

            // MUTHAWIF
            'muthawif_id' => $muthawif?->id,
            // 'muthawif_name' => $muthawif?->nama ?? null,

            // MASKAPAI
            'maskapai_id' => $maskapai?->id,
            // 'maskapai_name' => $maskapai?->nama_maskapai ?? null,

            // BANDARA
            'bandara_id' => $bandara?->id,
            // 'bandara_name' => $bandara?->nama_bandara ?? null,

            // MAIN FIELDS
            'tanggal_keberangkatan' => Carbon::instance($tanggalKeberangkatan)->format('Y-m-d'),
            'jam_keberangkatan' => $this->faker->time('H:i'),
            'tanggal_kembali' => Carbon::instance($tanggalKembali)->format('Y-m-d'),

            'quota' => $quota,
            'sisa_quota' => $quota,

            'status' => $this->faker->randomElement(['draft', 'open', 'closed', 'full']),
        ];
    }
}
