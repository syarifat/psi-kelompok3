<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Siswa;
use Illuminate\Support\Carbon;

class ApiAbsensiController extends Controller
{
    public function store(Request $request)
    {
        $rfid = $request->input('rfid');
        if (!$rfid) {
            return response()->json([
                'status' => 'error',
                'message' => 'RFID wajib diisi',
            ], 400);
        }

        // Cari siswa berdasarkan RFID
        $siswa = Siswa::where('rfid', $rfid)->first();
        if (!$siswa) {
            return response()->json([
                'status' => 'notfound',
                'message' => 'RFID tidak terdaftar',
            ], 404);
        }

        $tanggal = date('Y-m-d');
        $jam = date('H:i:s');

        // Cek apakah sudah absen hari ini
        $sudahAbsen = Absensi::where('siswa_id', $siswa->id)
            ->where('tanggal', $tanggal)
            ->exists();
        if ($sudahAbsen) {
            return response()->json([
                'status' => 'sudah',
                'nama' => $siswa->nama,
                'jam_tap' => $jam,
            ]);
        }

        // Simpan absensi
        $absensi = Absensi::create([
            'siswa_id' => $siswa->id,
            'tanggal' => $tanggal,
            'jam' => $jam,
            'status' => 'hadir',
            'keterangan' => null,
            'user_id' => null,
        ]);

        return response()->json([
            'status' => 'ok',
            'nama' => $siswa->nama,
            'jam_tap' => $jam,
        ]);
    }

    public function index(Request $request)
    {
        $absensi = Absensi::with(['rombel.siswa', 'rombel.kelas'])
            ->when($request->search, function($q) use ($request) {
                $q->whereHas('siswa', function($qq) use ($request) {
                    $qq->where('nama', 'like', '%' . $request->search . '%')
                       ->orWhere('nis', 'like', '%' . $request->search . '%');
                });
            })
            ->when($request->tanggal, function($q) use ($request) {
                $q->whereDate('tanggal', $request->tanggal);
            })
            ->when($request->kelas_id, function($q) use ($request) {
                $q->whereHas('siswa.rombel', function($qq) use ($request) {
                    $qq->where('kelas_id', $request->kelas_id);
                });
            })
            ->orderBy('tanggal', 'desc')
            ->get();

        return response()->json($absensi->map(function($row) {
            return [
                'id' => $row->id,
                'siswa_nama' => $row->rombel && $row->rombel->siswa ? $row->rombel->siswa->nama : '-',
                'siswa_nis' => $row->rombel && $row->rombel->siswa ? $row->rombel->siswa->nis : '-',
                'kelas_nama' => $row->rombel && $row->rombel->kelas ? $row->rombel->kelas->nama : '-',
                'tanggal' => $row->tanggal,
                'jam' => $row->jam,
                'status' => $row->status,
                'keterangan' => $row->keterangan,
            ];
        }));
    }
}
