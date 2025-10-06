<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kantin extends Model
{
    use HasFactory;

    protected $table = 'kantin'; 
    protected $primaryKey = 'kantin_id'; 
    public $timestamps = true; 

    protected $fillable = [
        'nama_kantin',
    ];
}
