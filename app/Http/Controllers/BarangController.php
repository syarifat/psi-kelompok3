<?php
namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kantin;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::with('kantin')->get();
        return view('barang.index', compact('barangs'));
    }
}
