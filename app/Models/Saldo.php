<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Saldo extends Model
{
    protected $table = 'saldo';
    protected $fillable = ['siswa_id', 'saldo'];
    public $timestamps = false;

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
