<?php

namespace Database\Seeders;

use App\Models\Muthawif;
use Illuminate\Database\Seeder;

class MuthawifSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Muthawif::factory(10)->create();
    }
}
