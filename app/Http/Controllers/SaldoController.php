<?php
namespace App\Http\Controllers;

use App\Models\Saldo;
use Illuminate\Http\Request;

class SaldoController extends Controller
{
    public function index()
    {
        $saldos = Saldo::with('siswa')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('saldo.index', compact('saldos'));
    }
}
