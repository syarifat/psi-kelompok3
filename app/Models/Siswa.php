<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';

    protected $fillable = [
        'nama',
        'nis',
        'no_hp_ortu',
        'rfid',
        'status',
    ];

    public function rombel()
    {
        return $this->hasOne(\App\Models\RombelSiswa::class, 'siswa_id');
    }

    /**
     * RELASI BARU: Satu siswa memiliki satu saldo.
     */
    public function saldo()
    {
        return $this->hasOne(Saldo::class, 'siswa_id', 'id');
    }

    /**
     * RELASI BARU: Satu siswa memiliki banyak riwayat top up.
     */
    public function topups()
    {
        return $this->hasMany(Topup::class, 'siswa_id', 'id');
    }
    public function kelas()
    {
        return $this->hasOneThrough(
            \App\Models\Kelas::class,
            \App\Models\RombelSiswa::class,
            'siswa_id',    // Foreign key di RombelSiswa
            'id',          // Foreign key di Kelas
            'id',          // Local key di Siswa
            'kelas_id'     // Local key di RombelSiswa
        );
    }
}