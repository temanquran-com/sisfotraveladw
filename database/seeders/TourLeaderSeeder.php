<?php

namespace Database\Seeders;

use App\Models\TourLeader;
use Illuminate\Database\Seeder;

class TourLeaderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TourLeader::factory(10)->create();

    }
}
