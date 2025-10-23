<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LaporanTransaksiController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Transaksi::with(['siswa', 'items.barang', 'kantin'])
            ->orderBy('created_at', 'desc');

        // jika user terikat kantin (pemilik_kantin), batasi
        if ($user && $user->kantin_id) {
            $query->where('kantin_id', $user->kantin_id);
        }

        // filter tanggal bila ada
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        // hitung total dari clone query agar tidak terganggu paginate
        $total = (clone $query)->sum('total');

        $transaksi = $query->paginate(10);

        // debug info untuk view (hindari undefined variable)
        $debug = [
            'is_admin'  => $user->is_admin ?? false,
            'kantin_id' => $user->kantin_id ?? null,
            'raw_count' => DB::table('transaksi')->count(),
            'query_count'=> $transaksi->total()
        ];

        return view('laporan.transaksi', compact('transaksi', 'total', 'debug'));
    }
}