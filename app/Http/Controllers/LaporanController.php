<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Kantin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $isAdmin = optional($user)->is_admin ?? (optional($user)->role === 'admin');

        $kantinList = $isAdmin ? Kantin::orderBy('nama_kantin')->get() : collect();

        $query = Transaksi::with(['siswa','items.barang'])->orderBy('created_at','desc');

        if (!$isAdmin) {
            $query->where('kantin_id', $user->kantin_id);
        } else {
            if ($request->filled('kantin_id')) {
                $query->where('kantin_id', $request->kantin_id);
            }
        }

        if ($request->filled('month')) {
            try {
                $start = Carbon::createFromFormat('Y-m', $request->month)->startOfMonth();
                $end = Carbon::createFromFormat('Y-m', $request->month)->endOfMonth();
                $query->whereBetween('created_at', [$start, $end]);
            } catch (\Throwable $e) {
                // ignore invalid
            }
        }

        $total = (clone $query)->sum('total');
        $transaksi = $query->paginate(20)->withQueryString();

        if ($request->ajax()) {
            $rows = $transaksi->map(function($t){
                $items = $t->items->map(function($it){
                    $name = $it->barang->nama_barang ?? ($it->nama ?? 'Item');
                    return [
                        'name' => $name,
                        'qty' => $it->qty,
                        'subtotal' => number_format($it->subtotal,0,',','.'),
                        'line' => "{$name} ({$it->qty}x) : Rp " . number_format($it->subtotal,0,',','.')
                    ];
                })->values();

                return [
                    'transaksi_id' => $t->transaksi_id,
                    'created_at' => $t->created_at->format('d/m/Y H:i'),
                    'siswa' => $t->siswa->nama ?? '-',
                    'items' => $items,
                    'total' => number_format($t->total,0,',','.')
                ];
            });

            return response()->json([
                'data' => $rows,
                'meta' => [
                    'current_page' => $transaksi->currentPage(),
                    'last_page' => $transaksi->lastPage(),
                    'per_page' => $transaksi->perPage(),
                    'total' => $transaksi->total(),
                    'next_page_url' => $transaksi->nextPageUrl(),
                    'prev_page_url' => $transaksi->previousPageUrl(),
                ],
                'total_sum' => number_format($total,0,',','.'),
            ]);
        }

        return view('laporan.transaksi', compact('transaksi','total','kantinList'));
    }
}