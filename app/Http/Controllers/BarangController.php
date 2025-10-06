<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kantin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BarangController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'pemilik_kantin') {
            $barang = Barang::where('kantin_id', $user->kantin_id)->get();
        } else {
            $barang = Barang::with('kantin')->get();
        }

        return view('barang.index', compact('barang'));
    }

    public function create()
    {
        $user = Auth::user();
        $kantin = Kantin::all();

        return view('barang.create', compact('kantin', 'user'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama_barang'  => 'required|string|max:100',
            'harga_barang' => 'required|numeric|min:0',
            'kantin_id'    => $user->role === 'pemilik_kantin' ? 'nullable' : 'required|exists:kantin,kantin_id',
        ]);

        $kantinId = $user->role === 'pemilik_kantin'
            ? $user->kantin_id
            : $request->kantin_id;

        Barang::create([
            'nama_barang'  => $request->nama_barang,
            'harga_barang' => $request->harga_barang,
            'kantin_id'    => $kantinId,
        ]);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);

        if (Auth::user()->role === 'pemilik_kantin' && $barang->kantin_id !== Auth::user()->kantin_id) {
            abort(403, 'Anda tidak punya akses untuk hapus barang ini.');
        }

        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus.');
    }

    public function edit($id)
    {
        $barang = Barang::findOrFail($id);

        // cek agar pemilik kantin hanya bisa edit barangnya sendiri
        if (Auth::user()->role === 'pemilik_kantin' && $barang->kantin_id !== Auth::user()->kantin_id) {
            abort(403, 'Anda tidak punya akses untuk edit barang ini.');
        }

        return view('barang.edit', compact('barang'));
    }

    /**
     * Update barang
     */
    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        if (Auth::user()->role === 'pemilik_kantin' && $barang->kantin_id !== Auth::user()->kantin_id) {
            abort(403, 'Anda tidak punya akses untuk update barang ini.');
        }

        $request->validate([
            'nama_barang'   => 'required|string|max:100',
            'harga_barang'  => 'required|numeric|min:0',
        ]);

        $barang->update([
            'nama_barang'   => $request->nama_barang,
            'harga_barang'  => $request->harga_barang,
        ]);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diupdate.');
    }
}
