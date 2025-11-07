<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Transaksi;
use App\Models\TransaksiItem;
use App\Models\Kantin;

class DashboardPaymentController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $isAdmin = optional($user)->is_admin ?? (optional($user)->role === 'admin');
        $kantin_id = $user->kantin_id ?? null;

        $todayStart = Carbon::today();
        $monthStart = Carbon::now()->startOfMonth();

        // base metrics
        $totalMonth = 0;
        $totalToday = 0;
        $countToday = 0;
        $kantinCount = 0;
        $topKantin = collect();
        $topItems = collect();
        $recent = collect();
        $payments = collect();

        // metrics query scope helper
        $scopeQuery = function($query) use ($isAdmin, $kantin_id) {
            if (!$isAdmin && $kantin_id) {
                $query->where('kantin_id', $kantin_id);
            }
            return $query;
        };

        if ($isAdmin) {
            $totalMonth = $scopeQuery(Transaksi::query())->where('status','paid')
                ->whereBetween('created_at', [$monthStart, Carbon::now()])->sum('total');

            $totalToday = $scopeQuery(Transaksi::query())->where('status','paid')
                ->whereBetween('created_at', [$todayStart, Carbon::now()])->sum('total');

            $countToday = $scopeQuery(Transaksi::query())->whereBetween('created_at', [$todayStart, Carbon::now()])->count();

            $kantinCount = Kantin::count();

            $topKantin = Transaksi::selectRaw('kantin_id, SUM(total) as revenue')
                ->whereBetween('created_at', [$monthStart, Carbon::now()])
                ->groupBy('kantin_id')
                ->orderByDesc('revenue')
                ->limit(5)
                ->get()
                ->map(function($row){
                    $row->kantin = Kantin::find($row->kantin_id);
                    return $row;
                });

            $topItems = TransaksiItem::selectRaw('barang_id, SUM(qty) as qty_sold')
                ->groupBy('barang_id')
                ->orderByDesc('qty_sold')
                ->limit(10)
                ->with('barang')
                ->get();

            $recent = Transaksi::with('siswa')->orderBy('created_at','desc')->limit(8)->get();
        } else {
            $totalMonth = Transaksi::where('kantin_id',$kantin_id)->where('status','paid')
                ->whereBetween('created_at', [$monthStart, Carbon::now()])->sum('total');

            $totalToday = Transaksi::where('kantin_id',$kantin_id)->where('status','paid')
                ->whereBetween('created_at', [$todayStart, Carbon::now()])->sum('total');

            $countToday = Transaksi::where('kantin_id',$kantin_id)
                ->whereBetween('created_at', [$todayStart, Carbon::now()])->count();

            $recent = Transaksi::with('items')->where('kantin_id',$kantin_id)->orderBy('created_at','desc')->limit(8)->get();

            $topItems = TransaksiItem::selectRaw('barang_id, SUM(qty) as qty_sold')
                ->whereHas('transaksi', function($q) use ($kantin_id){
                    $q->where('kantin_id', $kantin_id);
                })
                ->groupBy('barang_id')
                ->orderByDesc('qty_sold')
                ->limit(5)
                ->with('barang')
                ->get();
        }

        // recent payments summary for compact card
        $payments = $recent->map(fn($t) => [
            'id' => $t->transaksi_id,
            'nama' => $t->siswa->nama ?? ($t->nama ?? '-'),
            'total' => $t->total,
            'time' => $t->created_at->format('d/m H:i')
        ]);

        // Chart data: last 7 days
        $days = 7;
        $dailyLabels = [];
        $dailyTotals = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $start = $date->copy()->startOfDay();
            $end = $date->copy()->endOfDay();
            $dailyLabels[] = $date->format('d M');
            $q = Transaksi::where('status','paid')->whereBetween('created_at', [$start, $end]);
            if (!$isAdmin && $kantin_id) $q->where('kantin_id', $kantin_id);
            $dailyTotals[] = (float) $q->sum('total');
        }

        // Chart data: last 6 months
        $months = 6;
        $monthlyLabels = [];
        $monthlyTotals = [];
        for ($m = $months - 1; $m >= 0; $m--) {
            $dt = Carbon::now()->startOfMonth()->subMonths($m);
            $start = $dt->copy()->startOfMonth();
            $end = $dt->copy()->endOfMonth();
            $monthlyLabels[] = $dt->format('M Y');
            $q = Transaksi::where('status','paid')->whereBetween('created_at', [$start, $end]);
            if (!$isAdmin && $kantin_id) $q->where('kantin_id', $kantin_id);
            $monthlyTotals[] = (float) $q->sum('total');
        }

        return view('dashboard.payment', compact(
            'isAdmin',
            'totalMonth',
            'totalToday',
            'countToday',
            'kantinCount',
            'topKantin',
            'topItems',
            'recent',
            'payments',
            'dailyLabels',
            'dailyTotals',
            'monthlyLabels',
            'monthlyTotals'
        ));
    }
}
