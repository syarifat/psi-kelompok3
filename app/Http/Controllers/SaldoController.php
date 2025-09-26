<?php
namespace App\Http\Controllers;

use App\Models\Saldo;
use App\Models\Siswa;
use Illuminate\Http\Request;

class SaldoController extends Controller
{
    public function index()
    {
        $saldos = Saldo::with('siswa')->get();
        return view('saldo.index', compact('saldos'));
    }
}
