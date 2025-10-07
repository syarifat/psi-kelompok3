<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Kelas extends Model
{
    protected $table = 'kelas';
    protected $fillable = ['nama'];
        
    public function rombelSiswas()
    {
        return $this->hasMany(\App\Models\RombelSiswa::class, 'kelas_id');
    }
}
