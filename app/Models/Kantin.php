<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kantin extends Model
{
    protected $table = 'kantin';
    protected $primaryKey = 'kantin_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = ['nama_kantin'];
}
