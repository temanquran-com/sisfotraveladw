<?php

namespace Database\Seeders;

use App\Models\PaketUmroh;
use Illuminate\Database\Seeder;

class PaketUmrohSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Buat 20 paket umroh acak
        PaketUmroh::factory()->count(20)->create();

        // Contoh data spesifik
        PaketUmroh::create([
            'nama_paket' => 'Paket Umroh VIP Februari',
            'deskripsi' => 'Program VIP dengan fasilitas hotel bintang 5.',
            'durasi_hari' => 12,
            'harga_paket' => 38000000,
            'hotel_mekah_id' => 1,   // pastikan ID tersedia
            'hotel_madinah_id' => 1,
            'maskapai_id' => 1,
            'tanggal_start' => '2025-02-02',
            'tanggal_end' => '2025-02-14',
            'include' => json_encode(['Visa', 'Hotel 5*', 'Makan 3x', 'Bus Private']),
            'exclude' => json_encode(['Pengeluaran Pribadi']),
            'syarat' => json_encode(['Paspor berlaku 6 bulan']),
            'thumbnail' => 'paket_vip.jpg',
            'is_active' => 1,
        ]);

    }
}
