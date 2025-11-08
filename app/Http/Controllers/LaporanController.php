<?php

namespace App\Http\Controllers;

use App\Models\Kantin;
use App\Models\Transaksi;
use App\Models\TransaksiItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function income(Request $request)
    {
        $user = auth()->user();
        $isAdmin = $user->role === 'admin';
        
        $kantins = $isAdmin ? Kantin::all() : collect([$user->kantin]);
        
        $query = Transaksi::where('status', 'paid')
            ->when(!$isAdmin, fn($q) => $q->where('kantin_id', $user->kantin_id))
            ->when($request->kantin_id, fn($q) => $q->where('kantin_id', $request->kantin_id));

        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now();
        
        $query->whereBetween('created_at', [$startDate->startOfDay(), $endDate->endOfDay()]);

        $transactionIds = $query->pluck('transaksi_id');

        $metrics = [
            'summary' => [
                'total_income' => $query->sum('total'),
                'total_transactions' => $query->count(),
                'average_transaction' => $query->avg('total') ?? 0,
                'total_items_sold' => TransaksiItem::whereIn('transaksi_id', $transactionIds)->sum('qty'),
            ],
            'daily_income' => $this->getDailyIncome($query->getQuery()),
            'top_products' => $this->getTopProducts($transactionIds),
        ];

        return view('laporan.income', compact('metrics', 'kantins', 'isAdmin', 'startDate', 'endDate'));
    }

    public function transaksi(Request $request)
    {
        $user = auth()->user();
        $isAdmin = $user->role === 'admin';
        
        $kantins = $isAdmin ? Kantin::all() : collect([$user->kantin]);
        
        $query = Transaksi::with(['kantin', 'siswa', 'items.barang'])
            ->when(!$isAdmin, fn($q) => $q->where('kantin_id', $user->kantin_id))
            ->when($request->kantin_id, fn($q) => $q->where('kantin_id', $request->kantin_id))
            ->when($request->filled(['start_date', 'end_date']), function($q) use ($request) {
                $q->whereBetween('created_at', [
                    Carbon::parse($request->start_date)->startOfDay(),
                    Carbon::parse($request->end_date)->endOfDay()
                ]);
            });

        $transaksis = $query->latest()->paginate(15);

        return view('laporan.transaksi', compact('transaksis', 'kantins', 'isAdmin'));
    }

    private function getDailyIncome($query)
    {
        return DB::table('transaksi')
            ->selectRaw('DATE(created_at) as date')
            ->selectRaw('SUM(total) as total_income')
            ->selectRaw('COUNT(*) as total_transactions')
            ->where('status', 'paid')
            ->whereRaw("transaksi_id IN ({$query->select('transaksi_id')->toSql()})")
            ->mergeBindings($query)
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();
    }

    private function getTopProducts($transactionIds)
    {
        return TransaksiItem::whereIn('transaksi_id', $transactionIds)
            ->select(
                'barang_id',
                DB::raw('SUM(qty) as total_qty'),
                DB::raw('SUM(subtotal) as total_income')
            )
            ->with(['barang' => function($query) {
                $query->select('barang_id', 'nama_barang', 'harga_barang');
            }])
            ->groupBy('barang_id')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();
    }

    private function getHourlyStats($query)
    {
        return DB::table('transaksi')
            ->selectRaw('HOUR(created_at) as hour')
            ->selectRaw('COUNT(*) as total_transactions')
            ->selectRaw('SUM(total) as total_income')
            ->selectRaw('AVG(total) as average_transaction')
            ->where('status', 'paid')
            ->whereRaw("transaksi_id IN ({$query->select('transaksi_id')->toSql()})")
            ->mergeBindings($query)
            ->groupBy(DB::raw('HOUR(created_at)'))
            ->orderBy('hour')
            ->get();
    }

    private function getDailyStats($query)
    {
        return DB::table('transaksi')
            ->selectRaw('DAYNAME(created_at) as day')
            ->selectRaw('COUNT(*) as total_transactions')
            ->selectRaw('SUM(total) as total_income')
            ->selectRaw('AVG(total) as average_transaction')
            ->where('status', 'paid')
            ->whereRaw("transaksi_id IN ({$query->select('transaksi_id')->toSql()})")
            ->mergeBindings($query)
            ->groupBy(DB::raw('DAYNAME(created_at)'))
            ->orderByRaw("FIELD(DAYNAME(created_at), 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')")
            ->get();
    }
}