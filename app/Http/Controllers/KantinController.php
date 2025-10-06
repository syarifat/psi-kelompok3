<?php

namespace App\Http\Controllers;

use App\Models\Kantin;
use Illuminate\Http\Request;

class KantinController extends Controller
{
    public function index()
    {
        $kantins = Kantin::latest()->get(); // Lebih baik urutkan berdasarkan yang terbaru
        return view('kantin.index', compact('kantins'));
    }

    public function create()
    {
        return view('kantin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kantin' => 'required|string|max:255',
        ]);

        try {
            Kantin::create([
                'nama_kantin' => $request->nama_kantin,
            ]);
            return redirect()->route('kantin.index')->with('success', 'Kantin berhasil ditambahkan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambah kantin: ' . $e->getMessage());
        }
    }


    public function edit(Kantin $kantin) // Menggunakan Route Model Binding
    {
        return view('kantin.edit', compact('kantin'));
    }

    public function update(Request $request, Kantin $kantin) // Menggunakan Route Model Binding
    {
        $request->validate([
            'nama_kantin' => 'required|string|max:255',
        ]);

        // Cukup panggil update pada instance kantin
        $kantin->update([
            'nama_kantin' => $request->nama_kantin,
        ]);

        return redirect()->route('kantin.index')->with('success', 'Kantin berhasil diupdate!');
    }

    public function destroy(Kantin $kantin) // Menggunakan Route Model Binding
    {
        $kantin->delete();
        return redirect()->route('kantin.index')->with('success', 'Kantin berhasil dihapus!');
    }
}
