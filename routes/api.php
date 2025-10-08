<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiAbsensiController;
use App\Http\Controllers\Api\ApiSiswaController;
use App\Http\Controllers\Api\RombelSiswaApiController;
use Illuminate\Support\Facades\Cache;
use App\Models\Siswa;

Route::post('/absensi-api', [ApiAbsensiController::class, 'store']);
Route::get('/siswa-api', [ApiSiswaController::class, 'index']);
Route::get('/rombel-siswa', [RombelSiswaApiController::class, 'index']);
Route::get('/siswa', [\App\Http\Controllers\Api\SiswaApiController::class, 'index']);
// fetch absensi terbaru
Route::get('/absensi-terbaru', function(Request $request) {
	$query = \App\Models\Absensi::with('siswa')->orderBy('id', 'desc');
	if ($request->filled('search')) {
		$search = $request->search;
		$query->whereHas('siswa', function($q) use ($search) {
			$q->where('nama', 'like', "%$search%")
			  ->orWhere('nis', 'like', "%$search%");
		});
	}
	if ($request->filled('tanggal')) {
		$query->where('tanggal', $request->tanggal);
	}
	if ($request->filled('kelas_id')) {
		$query->whereHas('siswa', function($q) use ($request) {
			$q->whereIn('id', \App\Models\RombelSiswa::where('kelas_id', $request->kelas_id)
				->pluck('siswa_id')->toArray());
		});
	}
	$absensi = $query->limit(30)->get()->map(function($row) {
		$rombel = $row->siswa ? $row->siswa->rombel : null;
		return [
			'id' => $row->id,
			'siswa_nama' => $row->siswa->nama ?? '-',
			'nomor_absen' => $rombel ? $rombel->nomor_absen : '-',
			'siswa_nis' => $row->siswa->nis ?? '-',
			'kelas_nama' => ($rombel && $rombel->kelas) ? $rombel->kelas->nama : '-',
			'tanggal' => $row->tanggal,
			'jam' => $row->jam,
			'status' => ucfirst($row->status),
			'keterangan' => $row->keterangan,
		];
	});
	return response()->json($absensi);
});

// Saat scan RFID, simpan ID siswa ke cache
Route::post('/rfid-scan', function(Request $request) {
    $uid = $request->uid;
    $siswa = Siswa::where('rfid', $uid)->first();
    if ($siswa) {
        Cache::put('topup_siswa_id', $siswa->id, now()->addMinutes(2));
        return response()->json(['status' => 'ok', 'siswa' => $siswa]);
    }
    return response()->json(['status' => 'not_found']);
});

// Polling data siswa yang sedang di-topup
Route::get('/topup/current', function() {
    $id = Cache::get('topup_siswa_id');
    $siswa = $id ? Siswa::find($id) : null;
    return response()->json(['siswa' => $siswa]);
});
Route::post('/topup/reset', function() {
    Cache::forget('topup_siswa_id');
    return response()->json(['status' => 'reset']);
});