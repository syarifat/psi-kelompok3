<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index()
    {
        $guru = Guru::all();
        return view('guru.index', compact('guru'));
    }

    public function create()
    {
        return view('guru.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'nip' => 'nullable|string|max:30',
            'no_hp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'alamat' => 'nullable|string',
            'status' => 'required|string',
        ]);
        $guru = Guru::create($request->all());

        // Tambahkan ke tabel users jika email ada dan belum terdaftar
        if ($guru->email) {
            $user = \App\Models\User::where('email', $guru->email)->first();
            if (!$user) {
                \App\Models\User::create([
                    'name' => $guru->nama,
                    'email' => $guru->email,
                    'password' => null,
                    'role' => 'guru',
                ]);
            }
        }
        return redirect()->route('guru.index')->with('success', 'Guru berhasil ditambahkan dan akun user guru dibuat.');
    }

    public function edit($id)
    {
        $guru = Guru::findOrFail($id);
        return view('guru.edit', compact('guru'));
    }

    public function update(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);
        $request->validate([
            'nama' => 'required|string|max:100',
            'nip' => 'nullable|string|max:30',
            'no_hp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'alamat' => 'nullable|string',
            'status' => 'required|string',
        ]);
        $guru->update($request->all());
        return redirect()->route('guru.index')->with('success', 'Guru berhasil diupdate.');
    }

    public function destroy($id)
    {
        $guru = Guru::findOrFail($id);
        $guru->delete();
        return redirect()->route('guru.index')->with('success', 'Guru berhasil dihapus.');
    }
}
