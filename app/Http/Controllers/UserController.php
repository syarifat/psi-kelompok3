<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kantin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // ambil user + kantin (jika ada)
        $users = User::with('kantin')->get();
        return view('user.index', compact('users'));
    }

    public function create()
    {
        $kantin = Kantin::all(); // kirim daftar kantin ke view
        return view('user.create', compact('kantin'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:100',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|string|min:6',
            'role'      => 'required|string|in:superadmin,admin,pemilik_kantin',
            'kantin_id' => 'nullable|exists:kantin,kantin_id',
        ]);

        // kalau role pemilik_kantin wajib pilih kantin
        if ($request->role === 'pemilik_kantin' && !$request->kantin_id) {
            return back()->withErrors(['kantin_id' => 'Pemilik kantin wajib memilih kantin'])->withInput();
        }

        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role'      => $request->role,
            'kantin_id' => $request->role === 'pemilik_kantin' ? $request->kantin_id : null,
        ]);

        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user   = User::findOrFail($id);
        $kantin = Kantin::all();
        return view('user.edit', compact('user', 'kantin'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'      => 'required|string|max:100',
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'password'  => 'nullable|string|min:6',
            'role'      => 'required|string|in:superadmin,admin,pemilik_kantin',
            'kantin_id' => 'nullable|exists:kantin,kantin_id',
        ]);

        if ($request->role === 'pemilik_kantin' && !$request->kantin_id) {
            return back()->withErrors(['kantin_id' => 'Pemilik kantin wajib memilih kantin'])->withInput();
        }

        $data = [
            'name'      => $request->name,
            'email'     => $request->email,
            'role'      => $request->role,
            'kantin_id' => $request->role === 'pemilik_kantin' ? $request->kantin_id : null,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('user.index')->with('success', 'User berhasil diupdate.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('user.index')->with('success', 'User berhasil dihapus.');
    }
}
