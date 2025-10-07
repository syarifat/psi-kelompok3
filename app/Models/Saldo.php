<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Saldo extends Model
{
    protected $table = 'saldo';
    protected $fillable = ['siswa_id', 'saldo'];
    public $timestamps = false; // Kolom created_at & updated_at tidak digunakan

    /**
     * Relasi: Satu saldo dimiliki oleh satu siswa.
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id', 'id');
    }
}