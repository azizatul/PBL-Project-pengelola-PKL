<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Dosen;
use App\Models\User;

class DosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Dosen::create([
            'nama_dosen' => 'Dr. Ahmad Rahman',
            'nip' => '198001011234567890',
            'email' => 'ahmad.rahman@univ.ac.id',
            'alamat' => 'Jl. Sudirman No. 1',
            'telepon' => '081234567890',
        ]);

        Dosen::create([
            'nama_dosen' => 'Prof. Siti Nurhaliza',
            'nip' => '197512151234567891',
            'email' => 'siti.nurhaliza@univ.ac.id',
            'alamat' => 'Jl. Thamrin No. 2',
            'telepon' => '081234567891',
        ]);

        Dosen::create([
            'nama_dosen' => 'Dr. Muhammad Iqbal',
            'nip' => '198512201234567892',
            'email' => 'muhammad.iqbal@univ.ac.id',
            'alamat' => 'Jl. Gatot Subroto No. 3',
            'telepon' => '081234567892',
        ]);
    }
}
