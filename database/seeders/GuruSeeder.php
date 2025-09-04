<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Guru;

class GuruSeeder extends Seeder
{
    public function run(): void
    {
        Guru::create([
            'nama' => 'Ahmad Fauzi',
            'nip' => '1978123456',
            'no_hp' => '081234567890',
            'email' => 'ahmad@guru.com',
            'alamat' => 'Jl. Mawar No. 1',
            'status' => 'aktif',
        ]);
        Guru::create([
            'nama' => 'Siti Rahma',
            'nip' => '1980123457',
            'no_hp' => '081234567891',
            'email' => 'siti@guru.com',
            'alamat' => 'Jl. Melati No. 2',
            'status' => 'aktif',
        ]);
    }
}
