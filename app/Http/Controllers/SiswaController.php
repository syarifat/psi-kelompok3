<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\TahunAjaran;

class SiswaController extends Controller
{
    public function index()
    {
        $siswa = \App\Models\Siswa::paginate(20);
        return view('siswa.index', compact('siswa'));
    }
    public function create()
    {
        return view('siswa.create');
    }
    public function edit($id)
    {
        $siswa = \App\Models\Siswa::findOrFail($id);
        return view('siswa.edit', compact('siswa'));
    }

    public function update(Request $request, $id)
    {
        $siswa = \App\Models\Siswa::findOrFail($id);
        $request->validate([
            'nama' => 'required',
            'nis' => 'required|unique:siswa,nis,' . $siswa->id,
            'no_hp_ortu' => 'required',
            'rfid' => 'required|unique:siswa,rfid,' . $siswa->id,
            'status' => 'required',
        ]);
        $siswa->update($request->only(['nama','nis','no_hp_ortu','rfid','status']));
        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil diupdate');
    }
    public function destroy($id)
    {
        $siswa = \App\Models\Siswa::findOrFail($id);
        $siswa->delete();
        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil dihapus');
    }
    public function store(Request $request)
    {
    $request->validate([
        'nama' => 'required',
        'nis' => 'required|unique:siswa,nis',
        'no_hp_ortu' => 'required',
        'rfid' => 'required|unique:siswa,rfid',
        'status' => 'required',
    ]);
    \App\Models\Siswa::create($request->only(['nama','nis','no_hp_ortu','rfid','status']));
    return redirect()->route('siswa.index')->with('success', 'Siswa berhasil ditambahkan');
}
}
