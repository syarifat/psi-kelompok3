<?php
namespace App\Http\Controllers;

use App\Models\Kantin;
use Illuminate\Http\Request;

class KantinController extends Controller
{
    public function index()
    {
        $kantins = Kantin::all();
        return view('kantin.index', compact('kantins'));
    }
}
