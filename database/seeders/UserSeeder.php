<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dosen = User::create([
          'name' => 'Dosen Dimas',
          'email' => 'dimasdosen@elearning.com',
          'password' => bcrypt('password123'),
        ]);
        $dosen->assignRole('dosen');

        $mahasiswa = User::create([
          'name' => 'Mahasiswa nurul',
          'email' => 'nurulmahasiswa@elearning.com',
          'password' => bcrypt('password123'),
        ]);
        $mahasiswa->assignRole('mahasiswa');
    }
}
