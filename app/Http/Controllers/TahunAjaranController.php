<?php

namespace App\Http\Controllers;

use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class TahunAjaranController extends Controller
{
    public function index()
    {
        $tahunAjaran = TahunAjaran::all();
        return view('tahun_ajaran.index', compact('tahunAjaran'));
    }

    public function create()
    {
        return view('tahun_ajaran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
        ]);
        TahunAjaran::create([
            'nama' => $request->nama,
            'aktif' => $request->aktif ?? 0,
        ]);
        return redirect()->route('tahun_ajaran.index')->with('success', 'Tahun ajaran berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $tahunAjaran = TahunAjaran::findOrFail($id);
        return view('tahun_ajaran.edit', compact('tahunAjaran'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
        ]);
        $tahunAjaran = TahunAjaran::findOrFail($id);
        $tahunAjaran->update([
            'nama' => $request->nama,
            'aktif' => $request->aktif ?? 0,
        ]);
        return redirect()->route('tahun_ajaran.index')->with('success', 'Tahun ajaran berhasil diupdate.');
    }

    public function destroy($id)
    {
        $tahunAjaran = TahunAjaran::findOrFail($id);
        $tahunAjaran->delete();
        return redirect()->route('tahun_ajaran.index')->with('success', 'Tahun ajaran berhasil dihapus.');
    }
}
