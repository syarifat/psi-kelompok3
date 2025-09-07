<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class KirimNotifikasiSiswaBelumAbsen extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifikasi:siswa-belum-absen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirim notifikasi ke orang tua jika siswa belum absen sampai jam 9 pagi';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d');

        $this->info('Mencari siswa yang belum absen pada ' . $tanggal . ' ...');

        $siswaList = \App\Models\Siswa::with(['rombel.kelas'])->get();
        $jumlah = 0;
        foreach ($siswaList as $siswa) {
            $sudahAbsen = \App\Models\Absensi::where('siswa_id', $siswa->id)
                ->where('tanggal', $tanggal)
                ->exists();
            if (!$sudahAbsen && $siswa->no_hp_ortu) {
                $wa = $siswa->no_hp_ortu;
                if (substr($wa, 0, 1) === '0') {
                    $wa = '62' . substr($wa, 1);
                }
                $kelas = ($siswa->rombel && $siswa->rombel->kelas) ? $siswa->rombel->kelas->nama : '-';
                $nama_sekolah = env('NAMA_SEKOLAH');
                $hari = [
                    'Sunday' => 'Minggu',
                    'Monday' => 'Senin',
                    'Tuesday' => 'Selasa',
                    'Wednesday' => 'Rabu',
                    'Thursday' => 'Kamis',
                    'Friday' => 'Jumat',
                    'Saturday' => 'Sabtu',
                ];
                $carbon = \Carbon\Carbon::parse($tanggal);
                $nama_hari = $hari[$carbon->format('l')] ?? $carbon->format('l');
                $tanggal_indo = $carbon->translatedFormat('d F Y');
                $message = "Assalamu’alaikum Bapak/Ibu,\n" .
                    "Kami informasikan bahwa putra/putri Bapak/Ibu:\n" .
                    "Nama   : {$siswa->nama}\n" .
                    "Kelas  : {$kelas}\n\n" .
                    "Hari ini, {$nama_hari}, {$tanggal_indo} hingga pukul 09:00, tercatat *BELUM HADIR* di sekolah.\n" .
                    "Mohon konfirmasi penyebab ketidakhadiran melalui wali kelas.\n" .
                    "Terima kasih atas perhatian dan kerja samanya. 🙏\n" .
                    "- {$nama_sekolah}";
                $fonnte = new \App\Services\FonnteService();
                $fonnte->sendMessage($wa, $message);
                $jumlah++;
            }
        }
        $this->info("Notifikasi dikirim ke {$jumlah} orang tua siswa yang belum absen.");
    }
}
