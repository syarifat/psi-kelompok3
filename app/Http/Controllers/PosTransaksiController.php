<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Siswa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Services\FonnteService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\Saldo;

class PosTransaksiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Filter barang sesuai kantin pemilik
        $barangList = Barang::where('kantin_id', $user->kantin_id)->get();
        $keranjang = session('keranjang', []);
        $total = collect($keranjang)->sum('subtotal');
        $siswa = session('siswa');
        return view('pos.index', compact('barangList', 'keranjang', 'total', 'siswa'));
    }

    public function tambahBarang(Request $request)
    {
        $user = Auth::user();
        $barang = Barang::where('kantin_id', $user->kantin_id)
            ->where('barang_id', $request->barang_id)
            ->first();
        if (!$barang) return back()->with('error', 'Barang tidak ditemukan');
        $qty = max(1, (int)$request->qty);

        // Ambil keranjang dari session
        $keranjang = session('keranjang', []);

        // Cek apakah barang sudah ada di keranjang
        $found = false;
        foreach ($keranjang as &$item) {
            if ($item['barang_id'] == $barang->barang_id) {
                // Jika sudah ada, tambahkan qty dan subtotal
                $item['qty'] += $qty;
                $item['subtotal'] = $item['harga'] * $item['qty'];
                $found = true;
                break;
            }
        }
        unset($item);

        // Jika belum ada, tambahkan barang baru
        if (!$found) {
            $keranjang[] = [
                'barang_id' => $barang->barang_id,
                'nama'      => $barang->nama_barang,
                'qty'       => $qty,
                'harga'     => $barang->harga_barang,
                'subtotal'  => $barang->harga_barang * $qty,
            ];
        }

        // Simpan kembali ke session
        session(['keranjang' => $keranjang]);
        return back();
    }

    public function hapusBarang($barang_id)
    {
        $keranjang = collect(session('keranjang', []))
            ->reject(fn($item) => $item['barang_id'] == $barang_id)
            ->values()->all();
        session(['keranjang' => $keranjang]);
        return back();
    }

    public function scanRfid(Request $request)
    {
        $uid = $request->uid;
        $siswa = Siswa::where('rfid', $uid)->first();
        if ($siswa) {
            session(['siswa' => $siswa]);
            return back();
        }
        return back()->with('error', 'Siswa tidak ditemukan');
    }

    public function bayar(Request $request)
    {
        $keranjang = session('keranjang', []);
        $total = collect($keranjang)->sum('subtotal');
        $siswa_id = \Cache::get('transaksi_siswa_id');
        $siswa = \App\Models\Siswa::find($siswa_id);
        $user = \Auth::user();
        $kantin_id = $user->kantin_id;

        // Ambil saldo siswa dari tabel saldo
        $saldo = \App\Models\Saldo::where('siswa_id', $siswa_id)->value('saldo');

        if (!$siswa || $saldo < $total) {
            return back()->with('error', 'Saldo siswa tidak cukup');
        }

        // Simpan transaksi
        $transaksi_id = \DB::table('transaksi')->insertGetId([
            'siswa_id'   => $siswa->id,
            'kantin_id'  => $kantin_id,
            'total'      => $total,
            'status'     => 'paid',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Simpan detail barang
        foreach ($keranjang as $item) {
            \DB::table('transaksi_item')->insert([
                'transaksi_id' => $transaksi_id,
                'barang_id'    => $item['barang_id'],
                'qty'          => $item['qty'],
                'harga'        => $item['harga'],
                'subtotal'     => $item['subtotal'],
            ]);
        }

        // Potong saldo siswa
        \App\Models\Saldo::where('siswa_id', $siswa_id)->decrement('saldo', $total);

        // --- START: kirim notifikasi WA ke orang tua (jika tersedia) ---
        try {
            // refresh saldo setelah decrement
            $saldoAkhir = Saldo::where('siswa_id', $siswa_id)->value('saldo');

            // ambil nomor ortu
            $noHpOrtu = $siswa->no_hp_ortu ?? $siswa->nomor_ortu ?? null;

            if (!$noHpOrtu) {
                Log::info('TransaksiNotify: no parent phone, skip notify', [
                    'siswa_id' => $siswa_id,
                    'transaksi_id' => $transaksi_id
                ]);
            } else {
                $wa = trim($noHpOrtu);
                if (str_starts_with($wa, '+')) $wa = ltrim($wa, '+');
                if (str_starts_with($wa, '0')) $wa = '62' . ltrim($wa, '0');

                // ambil items dari DB (pastikan nama kolom sesuai)
                $items = DB::table('transaksi_item')
                    ->where('transaksi_id', $transaksi_id)
                    ->get();

                // build item list string (cari nama barang)
                $itemLines = [];
                foreach ($items as $it) {
                    $barangName = DB::table('barang')->where('barang_id', $it->barang_id)->value('nama_barang') ?? 'Item';
                    $subtotalStr = number_format($it->subtotal, 0, ',', '.');
                    $itemLines[] = "- {$barangName} ({$it->qty}x) : Rp {$subtotalStr}";
                }
                $itemList = implode("\n", $itemLines);

                // tanggal & waktu (Bahasa Indonesia)
                $nowDate = Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY');
                $nowTime = Carbon::now()->format('H:i');

                $totalStr = number_format($total, 0, ',', '.');
                $saldoStr = number_format($saldoAkhir ?? 0, 0, ',', '.');

                $message = "Assalamu'alaikum Bapak/Ibu,\n\n"
                    . "Informasi Transaksi Kantin Siswa:\n"
                    . "Nama : {$siswa->nama}\n"
                    . "Tanggal : {$nowDate}\n"
                    . "Pukul : {$nowTime}\n\n"
                    . "Detail Pembelian:\n"
                    . "{$itemList}\n\n"
                    . "Total Pembelian : *Rp {$totalStr}*\n"
                    . "Sisa Saldo : *Rp {$saldoStr}*\n\n"
                    . "Terima kasih.\n- Sekolah";

                Log::info('TransaksiNotify: sending WA', [
                    'to' => $wa,
                    'transaksi_id' => $transaksi_id,
                    'message_preview' => substr($message, 0, 200)
                ]);

                if (class_exists(FonnteService::class)) {
                    $svc = new FonnteService();
                    $svc->sendMessage($wa, $message);
                    Log::info('TransaksiNotify: WA sent', ['to' => $wa, 'transaksi_id' => $transaksi_id]);
                } else {
                    Log::warning('TransaksiNotify: FonnteService missing, logged message instead', [
                        'to' => $wa,
                        'message' => $message
                    ]);
                }
            }
        } catch (\Throwable $e) {
            Log::error('TransaksiNotify: failed', [
                'error' => $e->getMessage(),
                'transaksi_id' => $transaksi_id
            ]);
        }
        // --- END: kirim notifikasi ---

        // Kosongkan session dan cache
        session()->forget('keranjang');
        \Cache::forget('transaksi_siswa_id');

        return back()->with('success', 'Transaksi berhasil! Saldo siswa sudah dipotong.');
    }
}