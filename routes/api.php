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
use App\Http\Controllers\TopupNotifyController;

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
        // ambil saldo dari tabel saldo
        $saldo = Saldo::where('siswa_id', $siswa->id)->value('saldo') ?? 0;

        Cache::put('topup_siswa', [
            'id' => $siswa->id,
            'nama' => $siswa->nama,
            'nis' => $siswa->nis,
        ], now()->addMinutes(2));

        return response()->json([
            'status' => 'ok',
            'siswa' => [
                'id' => $siswa->id,
                'nama' => $siswa->nama,
                'nis' => $siswa->nis,
                'saldo' => (float) $saldo,
            ]
        ]);
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
// Delegate API topup to controller that also sends notification / logs
// replaced direct controller route with closure that logs request/response
Route::post('/topup/store', function(\Illuminate\Http\Request $request) {
    \Log::info('API /api/topup/store called', [
        'payload' => $request->all(),
        'ip' => $request->ip(),
        'user_agent' => $request->header('User-Agent')
    ]);

    // resolve instance and call controller method
    $controller = app()->make(TopupNotifyController::class);
    $response = app()->call([$controller, 'apiStore'], ['request' => $request]);

    try {
        if ($response instanceof \Illuminate\Http\JsonResponse) {
            $body = $response->getData(true);
        } else {
            $body = (string) $response;
        }
    } catch (\Throwable $e) {
        $body = 'unable to serialize response: ' . $e->getMessage();
    }

    \Log::info('API /api/topup/store response', ['response' => $body]);

    return $response;
});
// Saat scan RFID untuk transaksi (bukan topup), simpan ID siswa ke cache
Route::post('/rfid-scan-transaksi', function(Request $request) {
    $uid = $request->uid;
    $siswa = Siswa::where('rfid', $uid)->first();
    if ($siswa) {
        // ambil saldo dari tabel saldo
        $saldo = Saldo::where('siswa_id', $siswa->id)->value('saldo') ?? 0;

        Cache::put('transaksi_siswa_id', $siswa->id, now()->addMinutes(2));
        return response()->json([
            'status' => 'ok',
            'siswa' => [
                'id' => $siswa->id,
                'nama' => $siswa->nama,
                'nis' => $siswa->nis,
                'saldo' => (float) $saldo,
            ]
        ]);
    }
    return response()->json(['status' => 'not_found']);
});
// Polling data siswa yang sedang transaksi (bukan topup)
Route::get('/transaksi/current', function() {
    $id = Cache::get('transaksi_siswa_id');
    $siswa = $id ? Siswa::find($id) : null;
    $saldo = $siswa ? Saldo::where('siswa_id', $siswa->id)->value('saldo') : 0;
    if ($siswa) {
        $siswa->saldo = $saldo; // tambahkan saldo ke objek siswa
    }
    return response()->json(['siswa' => $siswa]);
});
// Reset cache transaksi siswa
Route::post('/transaksi/reset', function() {
    Cache::forget('transaksi_siswa_id');
    return response()->json(['status' => 'reset']);
});