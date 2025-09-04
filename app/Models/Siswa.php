<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $fillable = [
        'nama',
        'nis',
        'no_hp_ortu',
        'rfid',
        'status',
    ];
    protected $table = 'siswa';

    public function rombel()
    {
        return $this->hasOne(\App\Models\RombelSiswa::class, 'siswa_id');
    }
    public function absensi()
    {
        return $this->hasMany(\App\Models\Absensi::class, 'siswa_id');
    }
}
