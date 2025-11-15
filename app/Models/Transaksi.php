<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaksi extends Model
{
    // sesuaikan dengan struktur DB
    protected $table = 'transaksi';
    protected $primaryKey = 'transaksi_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'siswa_id',
        'kantin_id',
        'total',
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'siswa_id', 'id');
    }

    public function kantin(): BelongsTo
    {
        return $this->belongsTo(Kantin::class, 'kantin_id', 'kantin_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(TransaksiItem::class, 'transaksi_id', 'transaksi_id');
    }

    /**
     * Alias supaya kode yang memanggil ->transaksiItems tetap berfungsi
     */
    public function transaksiItems(): HasMany
    {
        return $this->hasMany(TransaksiItem::class, 'transaksi_id', 'transaksi_id');
    }
}