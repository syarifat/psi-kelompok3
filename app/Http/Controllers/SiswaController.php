<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\TahunAjaran;

class SiswaController extends Controller
{
    public function index()
    {
        $siswa = \App\Models\Siswa::paginate(20);
        return view('siswa.index', compact('siswa'));
    }
    public function create()
    {
        return view('siswa.create');
    }
    public function edit($id)
    {
        $siswa = \App\Models\Siswa::findOrFail($id);
        return view('siswa.edit', compact('siswa'));
    }

    public function update(Request $request, $id)
    {
        $siswa = \App\Models\Siswa::findOrFail($id);
        $request->validate([
            'nama' => 'required',
            'nis' => 'required|unique:siswa,nis,' . $siswa->id,
            'no_hp_ortu' => 'required',
            'rfid' => 'required|unique:siswa,rfid,' . $siswa->id,
            'status' => 'required',
        ]);
        $siswa->update($request->only(['nama','nis','no_hp_ortu','rfid','status']));
        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil diupdate');
    }
    public function destroy($id)
    {
        $siswa = \App\Models\Siswa::findOrFail($id);
        $siswa->delete();
        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil dihapus');
    }
    public function store(Request $request)
    {
    $request->validate([
        'nama' => 'required',
        'nis' => 'required|unique:siswa,nis',
        'no_hp_ortu' => 'required',
        'rfid' => 'required|unique:siswa,rfid',
        'status' => 'required',
    ]);
    \App\Models\Siswa::create($request->only(['nama','nis','no_hp_ortu','rfid','status']));
    return redirect()->route('siswa.index')->with('success', 'Siswa berhasil ditambahkan');
}
public function searchLive(Request $request)
{
    $q = $request->get('q');

    // Join siswa, rombel_siswa, kelas
    $siswas = \DB::table('siswa')
        ->leftJoin('rombel_siswa', 'siswa.id', '=', 'rombel_siswa.siswa_id')
        ->leftJoin('kelas', 'rombel_siswa.kelas_id', '=', 'kelas.id')
        ->where(function($query) use ($q) {
            $query->where('siswa.nama', 'like', "%$q%")
                  ->orWhere('siswa.nis', 'like', "%$q%")
                  ->orWhere('kelas.nama', 'like', "%$q%");
        })
        ->select(
            'siswa.id',
            'siswa.nama',
            'siswa.nis',
            'kelas.nama as kelas_nama',
            'rombel_siswa.nomor_absen'
        )
        ->limit(20)
        ->get();

    // Format response untuk AJAX
    return response()->json($siswas);
}

public function topupHistori(Request $request)
{
    $siswa_id = $request->get('siswa_id');
    $histori = \App\Models\Topup::where('siswa_id', $siswa_id)
        ->orderByDesc('created_at')
        ->limit(10)
        ->get(['nominal', 'created_at']);

    return $histori->map(function($item) {
        return [
            'nominal' => $item->nominal,
            'created_at' => $item->created_at->format('d-m-Y H:i'),
        ];
    });
}
public function topupHistoriView($siswa_id)
{
    $siswa = \App\Models\Siswa::findOrFail($siswa_id);
    $topups = \App\Models\Topup::where('siswa_id', $siswa_id)->orderByDesc('waktu')->get();

    return view('siswa.topup_histori', compact('siswa', 'topups'));
}
}
