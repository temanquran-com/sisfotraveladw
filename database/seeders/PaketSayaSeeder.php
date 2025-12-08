<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\PaketSaya;
use Illuminate\Database\Seeder;

class PaketSayaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Creating 10 fake PaketSaya records
        PaketSaya::factory()->count(10)->create();
    }
}
