<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RombelSiswa extends Model
{
    protected $table = 'rombel_siswa';
    protected $fillable = [
        'siswa_id',
        'kelas_id',
        'tahun_ajaran_id',
    ];

    public function siswa()
    {
        return $this->belongsTo(\App\Models\Siswa::class, 'siswa_id');
    }

    public function kelas()
    {
        return $this->belongsTo(\App\Models\Kelas::class, 'kelas_id');
    }
    public function tahunAjaran() {
        return $this->belongsTo(TahunAjaran::class);
    }
    public function absensi()
    {
        return $this->hasMany(\App\Models\Absensi::class, 'siswa_id', 'siswa_id');
    }
}
