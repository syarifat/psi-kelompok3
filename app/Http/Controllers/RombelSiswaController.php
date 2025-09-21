<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RombelSiswa;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use Carbon\Carbon;
use PDF;

class RombelSiswaController extends Controller
{
    public function index()
    {
        $rombel = RombelSiswa::with(['siswa', 'kelas', 'tahunAjaran'])->get();
        return view('rombel_siswa.index', compact('rombel'));
    }

    public function create()
    {
        // Ambil siswa yang belum punya rombel_siswa (belum masuk kelas)
        $siswa = \App\Models\Siswa::whereDoesntHave('rombel')->get();
        $kelas = \App\Models\Kelas::all();
        $tahunAjaran = \App\Models\TahunAjaran::first();

        return view('rombel_siswa.create', compact('siswa', 'kelas', 'tahunAjaran'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'kelas_id' => 'required|exists:kelas,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
        ]);
        RombelSiswa::create($request->all());
        return redirect()->route('rombel_siswa.index')->with('success', 'Rombel siswa berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $rombel = RombelSiswa::findOrFail($id);
        $siswa = Siswa::all();
        $kelas = Kelas::all();
        $tahunAjaran = TahunAjaran::all();
        return view('rombel_siswa.edit', compact('rombel', 'siswa', 'kelas', 'tahunAjaran'));
    }

    public function update(Request $request, $id)
    {
        $rombel = RombelSiswa::findOrFail($id);
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'kelas_id' => 'required|exists:kelas,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
        ]);
        $rombel->update($request->all());
        return redirect()->route('rombel_siswa.index')->with('success', 'Rombel siswa berhasil diupdate.');
    }

    public function destroy($id)
    {
        $rombel = RombelSiswa::findOrFail($id);
        $rombel->delete();

        // Jika request AJAX/fetch, kirim 204 No Content
        if (request()->expectsJson()) {
            return response()->json(['success' => true], 200);
        }

        // Jika request biasa, redirect
        return redirect()->route('rombel_siswa.index')->with('success', 'Data berhasil dihapus');
    }

    public function mass_store(Request $request)
    {
        // Ambil semua siswa yang akan dimasukkan, urut nama ASC
        $siswaList = \App\Models\Siswa::whereIn('id', $request->siswa_id)
            ->orderBy('nama', 'asc')->get();

        $nomorAbsen = 1;
        foreach ($siswaList as $siswa) {
            $rombel = \App\Models\RombelSiswa::updateOrCreate([
                'siswa_id' => $siswa->id,
                'tahun_ajaran_id' => $request->tahun_ajaran_id,
            ], [
                'kelas_id' => $request->kelas_id,
            ]);
            $rombel->nomor_absen = $nomorAbsen;
            $rombel->save();
            $nomorAbsen++;
        }
        return redirect()->route('rombel_siswa.index')->with('success', 'Siswa berhasil dimasukkan ke kelas dan nomor absen diurutkan.');
    }

    public function gantiKelasMassal(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'kelas_baru_id' => 'required|exists:kelas,id',
        ]);

        try {
            // Ambil rombel lama sebelum update
            $rombelsLama = \App\Models\RombelSiswa::whereIn('id', $request->ids)->get();
            $kelasLamaIds = $rombelsLama->pluck('kelas_id')->unique();

            // Update kelas_id ke kelas baru
            \App\Models\RombelSiswa::whereIn('id', $request->ids)
                ->update(['kelas_id' => $request->kelas_baru_id]);

            // Update nomor_absen di kelas lama
            foreach ($kelasLamaIds as $kelasId) {
                $rombels = \App\Models\RombelSiswa::where('kelas_id', $kelasId)
                    ->orderBy('nomor_absen')->get();
                $siswaList = $rombels->sortBy(function($r) { return $r->siswa->nama ?? ''; });
                $no = 1;
                foreach ($siswaList as $rombel) {
                    $rombel->nomor_absen = $no;
                    $rombel->save();
                    $no++;
                }
            }

            // Update nomor_absen di kelas baru
            $rombelsBaru = \App\Models\RombelSiswa::where('kelas_id', $request->kelas_baru_id)
                ->get()->sortBy(function($r) { return $r->siswa->nama ?? ''; });
            $no = 1;
            foreach ($rombelsBaru as $rombel) {
                $rombel->nomor_absen = $no;
                $rombel->save();
                $no++;
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function exportPdf(Request $request)
    {
        $kelasId = $request->query('kelas_id');
        if (!$kelasId) {
            abort(400, 'kelas_id wajib diisi');
        }

        $kelas = \App\Models\Kelas::findOrFail($kelasId);
        $rombel = \App\Models\RombelSiswa::with('siswa', 'kelas', 'tahunAjaran')
            ->where('kelas_id', $kelasId)
            ->orderBy('nomor_absen')
            ->get();

        $fileName = "Daftar Siswa {$kelas->nama} - " . Carbon::now()->format('Y-m-d') . ".pdf";

        $pdf = PDF::loadView('rombel_siswa.pdf', [
            'kelas' => $kelas,
            'rombel' => $rombel
        ])->setPaper('a4', 'portrait');

        return $pdf->download($fileName);
    }
}
