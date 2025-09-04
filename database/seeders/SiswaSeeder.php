<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Siswa;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        Siswa::create([
            'nama' => 'Budi Santoso',
            'nis' => '1001',
            'rfid' => 'rfid1001',
            'no_hp_ortu' => '081234567890',
            'status' => 'aktif',
        ]);
        Siswa::create([
            'nama' => 'Siti Aminah',
            'nis' => '1002',
            'rfid' => 'rfid1002',
            'no_hp_ortu' => '081234567891',
            'status' => 'aktif',
        ]);
        Siswa::create([
            'nama' => 'Joko Prabowo',
            'nis' => '1003',
            'rfid' => 'rfid1003',
            'no_hp_ortu' => '081234567892',
            'status' => 'aktif',
        ]);
        Siswa::create([
            'nama' => 'Andi Setiawan',
            'nis' => '1004',
            'rfid' => 'rfid1004',
            'no_hp_ortu' => '081234567893',
            'status' => 'aktif',
        ]);
        Siswa::create([
            'nama' => 'Dewi Lestari',
            'nis' => '1005',
            'rfid' => 'rfid1005',
            'no_hp_ortu' => '081234567894',
            'status' => 'aktif',
        ]);
    }
}
