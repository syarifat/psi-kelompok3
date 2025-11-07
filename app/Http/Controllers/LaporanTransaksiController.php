<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        // Filter tanggal:
        // - jika kedua tanggal diisi -> range
        // - jika hanya start_date -> hanya hari itu
        // - jika hanya end_date -> hanya hari itu (end_date)
        $start = $request->input('start_date');
        $end = $request->input('end_date');

        if ($start && $end) {
            $query->whereBetween('created_at', [
                $start . ' 00:00:00',
                $end . ' 23:59:59',
            ]);
        } elseif ($start) {
            $query->whereDate('created_at', $start);
        } elseif ($end) {
            $query->whereDate('created_at', $end);
        }

        // hitung total dari clone query agar paginate tidak mempengaruhi sum
        $total = (clone $query)->sum('total');

        $transaksi = $query->paginate(10);

        return view('laporan.transaksi', compact('transaksi', 'total'));
    }
}