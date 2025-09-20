<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RombelSiswa;

class RombelSiswaApiController extends Controller
{
    public function index(Request $request)
    {
        $query = RombelSiswa::with(['siswa', 'kelas', 'tahunAjaran']);

        if ($request->search) {
            $query->whereHas('siswa', function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('nis', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->kelas_id) {
            $query->where('kelas_id', $request->kelas_id);
        }

        $data = $query->orderBy('id', 'desc')->get()->map(function($row) {
            return [
                'id' => $row->id,
                'nomor_absen' => $row->nomor_absen ?? '-',
                'siswa_nama' => $row->siswa->nama ?? '-',
                'siswa_nis' => $row->siswa->nis ?? '-',
                'kelas_nama' => $row->kelas->nama ?? '-',
                'tahun_ajaran_nama' => $row->tahunAjaran->nama ?? '-',
            ];
        });

        return response()->json($data);
    }
}