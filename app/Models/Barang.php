<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang';
    protected $primaryKey = 'barang_id';
    protected $fillable = ['kantin_id', 'nama_barang', 'harga_barang'];
    public $timestamps = false;

    public function kantin()
    {
        return $this->belongsTo(Kantin::class, 'kantin_id', 'kantin_id');
    }
}
