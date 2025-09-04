<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;

class ApiSiswaController extends Controller
{
    public function index()
    {
        $siswa = Siswa::all();
        return response()->json([
            'success' => true,
            'message' => 'List Data Siswa',
            'data' => $siswa
        ], 200);
    }
}
