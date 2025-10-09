<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Saldo;
use App\Models\Topup;
use Illuminate\Support\Facades\DB; // <-- Pastikan ini di-import

class TopupController extends Controller
{
    /**
     * Menampilkan halaman form top up.
     */
    public function create()
    {
        $historiAll = \App\Models\Topup::with('siswa.kelas')->orderByDesc('created_at')->limit(50)->get();
        return view('Topup.Topup', compact('historiAll'));
    }

    /**
     * Menyimpan data top up dan mengupdate saldo.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'nominal' => 'required|numeric|min:1000',
        ]);

        try {
            // 2. Gunakan DB Transaction untuk menjamin keamanan data
            DB::transaction(function () use ($request) {
                $siswa_id = $request->input('siswa_id');
                $nominal = $request->input('nominal');

                // Cari saldo siswa. Jika tidak ada, buat baru dengan saldo 0.
                $saldo = Saldo::firstOrCreate(
                    ['siswa_id' => $siswa_id],
                    ['saldo' => 0]
                );

                // Tambahkan saldo menggunakan increment yang aman
                $saldo->increment('saldo', $nominal);

                // Catat transaksi di tabel topup
                Topup::create([
                    'siswa_id' => $siswa_id,
                    'nominal' => $nominal,
                    'waktu' => now(), // Menggunakan waktu server saat ini
                ]);
            });

            // 3. Redirect kembali dengan pesan sukses
            return redirect()->route('pos.topup')->with('success', 'Top up saldo berhasil!');

        } catch (\Exception $e) {
            // Jika terjadi error, redirect kembali dengan pesan error
            return redirect()->route('pos.topup')->with('error', 'Gagal melakukan top up: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan riwayat top up untuk siswa tertentu.
     */
    public function show($siswa_id)
    {
        $siswa = \App\Models\Siswa::find($siswa_id);
        $histori = \App\Models\Topup::where('siswa_id', $siswa_id)
            ->orderByDesc('created_at')
            ->get();
        return view('topup.topup', compact('siswa', 'histori'));
    }
}