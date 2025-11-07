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
        return $this->hasOne(Saldo::class);
    }

    /**
     * RELASI BARU: Satu siswa memiliki banyak riwayat top up.
     */
    public function topups()
    {
        return $this->hasMany(Topup::class);
    }
}