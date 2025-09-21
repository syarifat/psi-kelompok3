<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use PDF;
use App\Models\Siswa;
use App\Models\RombelSiswa;
use App\Models\Absensi;

class RekapAbsensiController extends Controller
{
    public function export(Request $request, $type)
    {
        $kelasId = $request->input('kelas_id');
        $periode = $request->input('periode'); // format YYYY-MM

        if (!$kelasId || !$periode) {
            return back()->with('error', 'Pilih kelas dan bulan dulu sebelum export.');
        }

        if ($type === 'pdf') {
            return $this->generatePdf($kelasId, $periode);
        } elseif ($type === 'excel') {
            return $this->generateExcel($kelasId, $periode);
        }
    }

    private function generatePdf($kelasId, $periode)
    {
        $daysInMonth = Carbon::parse($periode . '-01')->daysInMonth;

        // Ambil siswa di kelas
        $rombel = RombelSiswa::with(['siswa','kelas'])
            ->where('kelas_id', $kelasId)
            ->get();

        $siswaIds = $rombel->pluck('siswa_id')->toArray();

        // Absensi bulan ini
        $absensi = Absensi::whereIn('siswa_id', $siswaIds)
            ->where('tanggal', 'like', "$periode%")
            ->get()
            ->groupBy('siswa_id');

        // Libur nasional dari API
        $tahun = substr($periode, 0, 4);
        $liburResponse = Http::get("https://dayoffapi.vercel.app/api?year=$tahun");
        $liburDates = [];
        if ($liburResponse->ok()) {
            foreach ($liburResponse->json() as $libur) {
                $tgl = Carbon::parse($libur['tanggal'])->format('Y-m-d');
                if (str_starts_with($tgl, $periode)) {
                    $liburDates[] = $tgl;
                }
            }
        }

        // Susun rekap
        $rekap = [];
        foreach ($rombel as $r) {
            $s = $r->siswa;
            $row = [
                'nama' => $s->nama,
                'nomor_absen' => $r->nomor_absen,
                'nis' => $s->nis,
                'data' => [],
                'H' => 0, 'S' => 0, 'I' => 0, 'A' => 0,
            ];

            for ($d=1; $d <= $daysInMonth; $d++) {
                $tgl = sprintf("%s-%02d", $periode, $d);

                // Cek apakah siswa punya data absensi
                $absenHariIni = isset($absensi[$s->id])
                    ? $absensi[$s->id]->firstWhere('tanggal', $tgl)
                    : null;

                $status = $absenHariIni ? $absenHariIni->status : null;

                // Default simbol
                $cell = '-';
                if ($status === 'hadir') { $cell = 'H'; $row['H']++; }
                elseif ($status === 'sakit') { $cell = 'S'; $row['S']++; }
                elseif ($status === 'izin')  { $cell = 'I'; $row['I']++; }
                elseif ($status === 'alpha') { $cell = 'A'; $row['A']++; }

                $row['data'][$d] = [
                    'status' => $cell,
                    'tanggal' => $tgl,
                    'is_sunday' => Carbon::parse($tgl)->isSunday(),
                    'is_libur'  => in_array($tgl, $liburDates),
                ];
            }

            $rekap[] = $row;
        }

        $kelasNama = $rombel->first()?->kelas->nama ?? '-';
        $periodeLabel = Carbon::parse($periode . '-01')->translatedFormat('F Y');

        // Buat nama file custom
        $fileName = "Rekap Kehadiran Siswa {$kelasNama} - {$periodeLabel}.pdf";

        $pdf = PDF::loadView('rekap.absensi_pdf', [
            'rekap' => $rekap,
            'daysInMonth' => $daysInMonth,
            'periode' => $periodeLabel,
            'kelas' => $kelasNama,
            'tahun' => $tahun,
        ])->setPaper('a4', 'landscape');

        return $pdf->download($fileName);

    }

    private function generateExcel($kelasId, $periode)
    {
        // nanti isi dengan maatwebsite/excel
        return "Export Excel belum diimplementasi";
    }
}
