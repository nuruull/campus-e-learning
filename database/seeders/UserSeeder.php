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

        $mahasiswa1 = User::create([
          'name' => 'Mahasiswa nurul',
          'email' => 'nurulmahasiswa@elearning.com',
          'password' => bcrypt('password123'),
        ]);
        $mahasiswa1->assignRole('mahasiswa');

        $mahasiswa2 = User::create([
          'name' => 'Mahasiswa gesang',
          'email' => 'gesangmahasiswa@elearning.com',
          'password' => bcrypt('password123'),
        ]);
        $mahasiswa2->assignRole('mahasiswa');
    }
}
