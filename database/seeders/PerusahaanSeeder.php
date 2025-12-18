<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Perusahaan;

class PerusahaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $perusahaans = [
            ['nama_perusahaan' => 'PT Mega Jasa Karya Bersama'],
            ['nama_perusahaan' => 'PT. SAMUDERA Indonesia'],
            ['nama_perusahaan' => 'PT. Japfa Comfeed Indonesia Tbk Unit Banjarmasin'],
            ['nama_perusahaan' => 'PT Ambang Barito Nusapersada'],
            ['nama_perusahaan' => 'PT. Bank Syariah Indonesia KCP Pelaihari'],
            ['nama_perusahaan' => 'RSUD H. Damanhuri Barabai'],
            ['nama_perusahaan' => 'Boejasin'],
            ['nama_perusahaan' => 'PT. Ciomas Adisatwa Bati-Bati'],
            ['nama_perusahaan' => 'PT PLN Persero ULP Gambut'],
            ['nama_perusahaan' => 'PT.pola Kahuripan Inti Sawit '],
        ];

        foreach ($perusahaans as $perusahaan) {
            Perusahaan::create($perusahaan);
        }
    }
}
