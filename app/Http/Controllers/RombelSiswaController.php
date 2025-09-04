<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RombelSiswa;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\TahunAjaran;

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
        foreach ($request->siswa_id as $siswaId) {
            \App\Models\RombelSiswa::updateOrCreate([
                'siswa_id' => $siswaId,
                'tahun_ajaran_id' => $request->tahun_ajaran_id,
            ], [
                'kelas_id' => $request->kelas_id,
            ]);
        }
        return redirect()->route('rombel_siswa.index')->with('success', 'Siswa berhasil dimasukkan ke kelas.');
    }

    public function gantiKelasMassal(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'kelas_baru_id' => 'required|exists:kelas,id',
        ]);

        try {
            \App\Models\RombelSiswa::whereIn('id', $request->ids)
                ->update(['kelas_id' => $request->kelas_baru_id]);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
