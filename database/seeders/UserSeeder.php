<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        \App\Models\User::create([
            'name' => 'Dosen',
            'email' => 'dosen@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'dosen',
        ]);

        \App\Models\User::create([
            'name' => 'Kaprodi',
            'email' => 'kaprodi@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'kaprodi',
        ]);

        \App\Models\User::create([
            'name' => 'Mahasiswa',
            'email' => 'mahasiswa@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'mahasiswa',
        ]);

        \App\Models\User::create([
            'name' => 'Perusahaan',
            'email' => 'perusahaan@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'perusahaan',
        ]);
    }
}
