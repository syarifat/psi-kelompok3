<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TandaiAlphaSiswaBelumAbsen extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'absensi:tandai-alpha';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Otomatis menandai siswa yang belum absen sampai jam 9 sebagai Alpha';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d');
        $jam = '09:00:00';
        $jumlah = 0;
        $siswaList = \App\Models\Siswa::with(['rombel.kelas'])->get();
        foreach ($siswaList as $siswa) {
            $sudahAbsen = \App\Models\Absensi::where('siswa_id', $siswa->id)
                ->where('tanggal', $tanggal)
                ->exists();
            if (!$sudahAbsen) {
                \App\Models\Absensi::create([
                    'siswa_id' => $siswa->id,
                    'tanggal' => $tanggal,
                    'jam' => $jam,
                    'status' => 'Alpha',
                    'keterangan' => 'Ditandai alpha oleh sistem',
                    'user_id' => null,
                ]);
                $jumlah++;
            }
        }
        $this->info("{$jumlah} siswa ditandai Alpha otomatis.");
    }
}
