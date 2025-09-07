<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Http\Controllers\Controller;

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
