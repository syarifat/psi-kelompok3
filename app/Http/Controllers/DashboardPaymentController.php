<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardPaymentController extends Controller
{
    public function index()
    {
        // contoh data payment dummy (bisa diganti ambil dari tabel Payment/Transaksi)
        $payments = [
            ['id' => 1, 'nama' => 'Pembayaran Kantin A', 'total' => 10000],
            ['id' => 2, 'nama' => 'Pembayaran Kantin B', 'total' => 15000],
            ['id' => 3, 'nama' => 'Pembayaran Kantin C', 'total' => 20000],
        ];

        return view('dashboard.payment', compact('payments'));
    }
}
