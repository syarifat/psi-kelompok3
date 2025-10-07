<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topup extends Model
{
    // Tentukan nama tabel yang digunakan oleh model ini
    protected $table = 'topup';

    // Tentukan primary key jika bukan 'id'
    protected $primaryKey = 'topup_id';

    // Matikan auto-increment jika primary key bukan integer
    public $incrementing = true; // ganti false jika topup_id bukan auto increment

    // Nonaktifkan timestamps (created_at & updated_at)
    public $timestamps = false;

    // Tentukan kolom yang boleh diisi secara massal
    protected $fillable = [
        'siswa_id',
        'nominal',
        'waktu',
    ];

    /**
     * Relasi: Satu data top up dimiliki oleh satu siswa.
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id', 'id');
    }
}