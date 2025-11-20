<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Saldo;
use App\Models\Topup;
use Illuminate\Support\Facades\DB;

class TopupController extends Controller
{
    /**
     * Menampilkan halaman form top up.
     */
    public function create()
    {
        // Ambil semua histori topup (tanpa pagination), urutkan DESC berdasarkan created_at
        $historiAll = Topup::with('siswa')
            ->orderByDesc('created_at')
            ->get();

        // return ke view yang konsisten (resources/views/topup/topup.blade.php)
        return view('topup.topup', compact('historiAll'));
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
        $siswa = Siswa::findOrFail($siswa_id);
        // ambil semua histori untuk siswa ini (tanpa pagination)
        $historiAll = Topup::where('siswa_id', $siswa_id)
            ->orderByDesc('created_at')
            ->get();

        return view('topup.topup', compact('siswa', 'historiAll'));
    }
}