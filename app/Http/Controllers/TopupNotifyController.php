<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use App\Models\Siswa;
use App\Models\Saldo;
use App\Models\Topup;
use App\Services\FonnteService; // jika tidak ada, try-catch akan mencegah crash

class TopupNotifyController extends Controller
{
    /**
     * Tampilkan form topup sederhana (opsional).
     */
    public function create()
    {
        $siswaList = Siswa::orderBy('nama')->get();
        return view('topup.create', compact('siswaList'));
    }

    /**
     * Lakukan topup dan kirim notifikasi ke orang tua jika nomor tersedia.
     */
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|integer|exists:siswa,id',
            'nominal'  => 'required|numeric|min:1',
        ]);

        $siswa = Siswa::find($request->input('siswa_id'));
        $nominal = (float) $request->input('nominal');

        DB::beginTransaction();
        try {
            $saldo = Saldo::firstOrCreate(
                ['siswa_id' => $siswa->id],
                ['saldo' => 0]
            );

            // increment saldo atomically
            $saldo->increment('saldo', $nominal);
            $saldo->refresh();

            // simpan riwayat topup jika tabel/model Topup ada
            if (class_exists(Topup::class)) {
                Topup::create([
                    'siswa_id' => $siswa->id,
                    'nominal'  => $nominal,
                    'user_id'  => auth()->id(),
                    'waktu'    => now(),
                ]);
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('TopupNotifyController::store error: '.$e->getMessage(), ['siswa_id' => $siswa->id ?? null, 'nominal' => $nominal]);
            return redirect()->route('pos.topup')->with('error', 'Gagal melakukan topup.');
        }

        // Kirim notifikasi ke orang tua (jika tersedia)
        try {
            $noHpOrtu = $siswa->no_hp_ortu ?? $siswa->nomor_ortu ?? null;
            if ($noHpOrtu) {
                // normalisasi no hp: jika mulai dengan 0 -> ganti ke 62
                $wa = trim($noHpOrtu);
                if (str_starts_with($wa, '0')) {
                    $wa = '62' . ltrim($wa, '0');
                }
                // format pesan (ubah: pisahkan tanggal dan pukul, format bahasa Indonesia)
                $nowDate = Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY');
                $nowTime = Carbon::now()->format('H:i');
                $nominalStr = number_format($nominal, 0, ',', '.');
                $saldoStr = number_format($saldo->saldo, 0, ',', '.');

                $message = "Assalamu'alaikum Bapak/Ibu,\n\n"
                    . "Topup Saldo Siswa berhasil.\n"
                    . "Nama : {$siswa->nama}\n"
                    . "Tanggal : {$nowDate}\n"
                    . "Pukul : {$nowTime}\n"
                    . "Nominal Topup : Rp {$nominalStr}\n"
                    . "Saldo total saat ini : Rp {$saldoStr}\n\n"
                    . "Terima kasih.\n- Sekolah";

                // jika service tersedia
                if (class_exists(FonnteService::class)) {
                    $svc = new FonnteService();
                    $svc->sendMessage($wa, $message);
                } else {
                    // jika tidak ada service, log saja
                    Log::info('TopupNotify - WA not sent (service missing)', ['to' => $wa, 'message' => $message]);
                }
            }
        } catch (\Throwable $e) {
            Log::warning('Gagal mengirim notifikasi topup: '.$e->getMessage(), ['siswa_id' => $siswa->id]);
            // jangan block alur utama
        }

        return redirect()->route('pos.topup')->with('success', 'Topup berhasil. Notifikasi dikirim jika nomor orang tua tersedia.');
    }

    /**
     * API: Reset cached siswa topup selection
     */
    public function apiReset(Request $request)
    {
        Cache::forget('topup_siswa');
        return response()->json(['status' => 'ok']);
    }

    /**
     * API: Return currently selected siswa for topup (from cache) + saldo
     */
    public function apiCurrent(Request $request)
    {
        $cached = Cache::get('topup_siswa');
        if (!$cached) {
            return response()->json(['siswa' => null]);
        }

        $siswa = Siswa::find($cached['id']);
        if (!$siswa) {
            return response()->json(['siswa' => null]);
        }

        $saldo = Saldo::where('siswa_id', $siswa->id)->value('saldo') ?? 0;
        return response()->json([
            'siswa' => [
                'id' => $siswa->id,
                'nama' => $siswa->nama,
                'nis' => $siswa->nis ?? null,
                'saldo' => (float) $saldo
            ]
        ]);
    }

    /**
     * API: perform topup and return JSON (used by front-end)
     */
    public function apiStore(Request $request)
    {
        $data = $request->only('siswa_id', 'nominal');
        $validator = \Validator::make($data, [
            'siswa_id' => 'required|integer|exists:siswa,id',
            'nominal'  => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        $siswa = Siswa::find($data['siswa_id']);
        $nominal = (float) $data['nominal'];

        DB::beginTransaction();
        try {
            $saldo = Saldo::firstOrCreate(
                ['siswa_id' => $siswa->id],
                ['saldo' => 0]
            );

            $saldo->increment('saldo', $nominal);
            $saldo->refresh();

            if (class_exists(Topup::class)) {
                Topup::create([
                    'siswa_id' => $siswa->id,
                    'nominal'  => $nominal,
                    'user_id'  => auth()->id(),
                    'waktu'    => now(),
                ]);
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('TopupNotifyController::apiStore error: '.$e->getMessage(), ['siswa_id' => $siswa->id ?? null, 'nominal' => $nominal]);
            return response()->json(['success' => false, 'message' => 'Gagal melakukan topup'], 500);
        }

        // Kirim notifikasi ke orang tua (jika tersedia) — log jika service tidak ada
        try {
            $noHpOrtu = $siswa->no_hp_ortu ?? $siswa->nomor_ortu ?? null;
            if ($noHpOrtu) {
                $wa = trim($noHpOrtu);
                if (str_starts_with($wa, '+')) $wa = ltrim($wa, '+');
                if (str_starts_with($wa, '0')) $wa = '62' . ltrim($wa, '0');

                $now = Carbon::now()->locale('id')->translatedFormat('l, d F Y H:i');
                $nominalStr = number_format($nominal, 0, ',', '.');
                $saldoStr = number_format($saldo->saldo, 0, ',', '.');

                $message = "Assalamu'alaikum Bapak/Ibu,\n\n"
                    . "Topup Saldo Siswa berhasil.\n"
                    . "Nama   : {$siswa->nama}\n"
                    . "Tanggal: {$now}\n"
                    . "Nominal: Rp {$nominalStr}\n"
                    . "Saldo saat ini: Rp {$saldoStr}\n\n"
                    . "Terima kasih.\n- Sekolah";

                if (class_exists(FonnteService::class)) {
                    $svc = new FonnteService();
                    $svc->sendMessage($wa, $message);
                    Log::info('TopupNotify - WA sent', ['to' => $wa, 'siswa_id' => $siswa->id]);
                } else {
                    Log::info('TopupNotify - WA not sent (service missing)', ['to' => $wa, 'message' => $message]);
                }
            } else {
                Log::info('TopupNotify - no parent phone', ['siswa_id' => $siswa->id]);
            }
        } catch (\Throwable $e) {
            Log::warning('Gagal mengirim notifikasi topup: '.$e->getMessage(), ['siswa_id' => $siswa->id]);
        }

        // Reset cache selection if used
        Cache::forget('topup_siswa');

        return response()->json(['success' => true, 'message' => 'Topup berhasil', 'saldo' => (float) $saldo->saldo]);
    }
}