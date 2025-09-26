<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kantin extends Model
{
    protected $table = 'kantin';
    protected $primaryKey = 'kantin_id';
    protected $fillable = ['nama_kantin'];
    public $timestamps = false;

    public function barang()
    {
        return $this->hasMany(Barang::class, 'kantin_id', 'kantin_id');
    }
}
