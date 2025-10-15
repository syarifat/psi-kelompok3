<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiAbsensiController;
use App\Http\Controllers\Api\ApiSiswaController;
use App\Http\Controllers\Api\RombelSiswaApiController;
use Illuminate\Support\Facades\Cache;
use App\Models\Siswa;
use App\Models\Saldo;
use App\Models\Topup;

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
        Cache::put('topup_siswa', [
            'id' => $siswa->id,
            'nama' => $siswa->nama,
            'nis' => $siswa->nis,
        ], now()->addMinutes(2));
        return response()->json(['status' => 'ok', 'siswa' => $siswa]);
    }
    return response()->json(['status' => 'not_found']);
});

// Polling data siswa yang sedang di-topup
Route::get('/topup/current', function() {
    $siswa = Cache::get('topup_siswa');
    if ($siswa) {
        $siswaModel = \App\Models\Siswa::with('saldo')->find($siswa['id']);
        return response()->json([
            'siswa' => [
                'id' => $siswaModel->id,
                'nama' => $siswaModel->nama,
                'nis' => $siswaModel->nis,
                'saldo' => $siswaModel->saldo ? $siswaModel->saldo->saldo : 0,
            ]
        ]);
    }
    return response()->json(['siswa' => null]);
});
Route::post('/topup/reset', function() {
    \Illuminate\Support\Facades\Cache::forget('topup_siswa');
    return response()->json(['success' => true]);
});
Route::post('/topup/store', function(Request $request) {
    $request->validate([
        'siswa_id' => 'required|exists:siswa,id',
        'nominal' => 'required|numeric|min:1000',
    ]);
    try {
        $siswa = Siswa::find($request->siswa_id);
        if (!$siswa) throw new \Exception('Siswa tidak ditemukan');
        // Ambil saldo siswa
        $saldo = Saldo::where('siswa_id', $siswa->id)->first();
        if (!$saldo) {
            // Jika belum ada, buat saldo baru
            $saldo = Saldo::create([
                'siswa_id' => $siswa->id,
                'saldo' => $request->nominal,
            ]);
        } else {
            // Jika sudah ada, tambahkan saldo
            $saldo->saldo += $request->nominal;
            $saldo->save();
        }
        // Catat histori topup
        Topup::create([
            'siswa_id' => $siswa->id,
            'nominal' => $request->nominal,
            'waktu' => now(),
        ]);
        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()]);
    }
});