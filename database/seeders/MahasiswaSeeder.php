<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Mahasiswa;
use App\Models\User;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create users for mahasiswa
        $user1 = User::firstOrCreate([
            'email' => 'halimatus@gmail.com',
        ], [
            'name' => 'St Halimatus Sadiah',
            'password' => bcrypt('password'),
            'role' => 'mahasiswa',
        ]);

        $user2 = User::firstOrCreate([
            'email' => 'azizatul@gmail.com',
        ], [
            'name' => 'Azizatul Mukarromah',
            'password' => bcrypt('password'),
            'role' => 'mahasiswa',
        ]);

        $user3 = User::firstOrCreate([
            'email' => 'syifa@gmail.com',
        ], [
            'name' => 'Syifa Kania Ardita',
            'password' => bcrypt('password'),
            'role' => 'mahasiswa',
        ]);

        $user4 = User::firstOrCreate([
            'email' => 'siti@gmail.com',
        ], [
            'name' => 'Siti Noor Mala Sari',
            'password' => bcrypt('password'),
            'role' => 'mahasiswa',
        ]);

        Mahasiswa::create([
            'user_id' => $user1->id,
            'nama_mahasiswa' => 'St Halimatus Sadiah',
            'nim' => '2021001',
            'email' => 'halimatus@gmail.com',
            'telepon' => '081234567890',
            'password' => bcrypt('password'),
            'angkatan' => '2021',
            'prodi_id' => 1,
            'status_validasi' => 'valid',
        ]);

        Mahasiswa::create([
            'user_id' => $user2->id,
            'nama_mahasiswa' => 'Azizatul Mukarromah',
            'nim' => '2021002',
            'email' => 'azizatul@gmail.com',
            'telepon' => '081234567891',
            'password' => bcrypt('password'),
            'angkatan' => '2021',
            'prodi_id' => 1,
            'status_validasi' => 'valid',
        ]);

        Mahasiswa::create([
            'user_id' => $user3->id,
            'nama_mahasiswa' => 'Syifa Kania Ardita',
            'nim' => '2021003',
            'email' => 'syifa@gmail.com',
            'telepon' => '081234567892',
            'password' => bcrypt('password'),
            'angkatan' => '2021',
            'prodi_id' => 1,
            'status_validasi' => 'valid',
        ]);

        Mahasiswa::create([
            'user_id' => $user4->id,
            'nama_mahasiswa' => 'Siti Noor Mala Sari',
            'nim' => '2021004',
            'email' => 'siti@gmail.com',
            'telepon' => '081234567893',
            'password' => bcrypt('password'),
            'angkatan' => '2021',
            'prodi_id' => 1,
            'status_validasi' => 'valid',
        ]);

        // Add the NIM from the user's attempt
        $user5 = User::firstOrCreate([
            'email' => 'mahasiswa2401301000@gmail.com',
        ], [
            'name' => 'Mahasiswa Test',
            'password' => bcrypt('password'),
            'role' => 'mahasiswa',
        ]);

        Mahasiswa::create([
            'user_id' => $user5->id,
            'nama_mahasiswa' => 'Mahasiswa Test',
            'nim' => '2401301000',
            'email' => 'mahasiswa2401301000@gmail.com',
            'telepon' => '081234567894',
            'password' => bcrypt('password'),
            'angkatan' => '2024',
            'prodi_id' => 1,
            'status_validasi' => 'valid',
        ]);
    }
}
