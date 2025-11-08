<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Saldo;
use Illuminate\Http\Request;

class SaldoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        
        $saldos = Saldo::with('siswa');

        if ($search) {
            $saldos->whereHas('siswa', function($query) use ($search) {
                $query->where('nama', 'like', "%{$search}%")
                      ->orWhere('nis', 'like', "%{$search}%");
            });
        }
        
        return $saldos->orderBy('created_at', 'desc')->get();
    }
}