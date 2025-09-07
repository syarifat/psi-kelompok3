<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use App\Models\Absensi;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now('Asia/Jakarta')->toDateString();

        $dataSiswaAktif = \App\Models\RombelSiswa::with(['siswa', 'kelas'])->get();
        $jumlahSiswa = $dataSiswaAktif->count();

        $dataHadir = \App\Models\Absensi::with(['siswa.rombel.kelas', 'rombel.kelas'])
            ->where('status', 'Hadir')
            ->whereDate('tanggal', $today)
            ->get();

        $dataSakitIzin = \App\Models\Absensi::with(['siswa.rombel.kelas', 'rombel.kelas'])
            ->whereIn('status', ['Sakit', 'Izin'])
            ->whereDate('tanggal', $today)
            ->get();

        $dataTanpaKeterangan = \App\Models\Absensi::with(['siswa.rombel.kelas', 'rombel.kelas'])
            ->whereIn('status', ['Tanpa Keterangan', 'Alpha'])
            ->whereDate('tanggal', $today)
            ->get();

        // Belum Hadir: ambil dari rombel_siswa yang tidak punya absensi hari ini
        $dataBelumHadir = \App\Models\RombelSiswa::with(['siswa', 'kelas'])
            ->whereDoesntHave('absensi', function($q) use ($today) {
                $q->whereDate('tanggal', $today);
            })->get();

        $jumlahHadir = $dataHadir->count();
        $jumlahSakitIzin = $dataSakitIzin->count();
        $jumlahTanpaKeterangan = $dataTanpaKeterangan->count();
        $jumlahBelumHadir = $dataBelumHadir->count();

        return view('dashboard', compact(
            'dataSiswaAktif',
            'jumlahSiswa',
            'dataHadir',
            'jumlahHadir',
            'dataSakitIzin',
            'jumlahSakitIzin',
            'dataTanpaKeterangan',
            'jumlahTanpaKeterangan',
            'dataBelumHadir',
            'jumlahBelumHadir'
        ));
    }
}