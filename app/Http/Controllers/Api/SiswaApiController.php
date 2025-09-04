<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;

class SiswaApiController extends Controller
{
    public function index(Request $request)
    {
        $query = Siswa::query();

        if ($request->search) {
            $query->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('nis', 'like', '%' . $request->search . '%');
        }

        $data = $query->orderBy('nama')->get();

        return response()->json($data);
    }
}