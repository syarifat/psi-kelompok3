<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kelas;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        Kelas::create(['nama' => 'VII A']);
        Kelas::create(['nama' => 'VII B']);
        Kelas::create(['nama' => 'VIII A']);
        Kelas::create(['nama' => 'VIII B']);
    }
}
