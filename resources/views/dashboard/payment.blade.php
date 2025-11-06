@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4">
    <h1 class="text-2xl font-semibold mb-6">Dashboard Pembayaran</h1>

    <!-- Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white shadow rounded-lg p-4">
            <div class="text-xs text-gray-500">Pendapatan Bulan Ini</div>
            <div class="mt-2 text-xl font-bold text-green-700">Rp {{ number_format($totalMonth ?? 0,0,',','.') }}</div>
        </div>

        <div class="bg-white shadow rounded-lg p-4">
            <div class="text-xs text-gray-500">Pendapatan Hari Ini</div>
            <div class="mt-2 text-xl font-bold text-green-600">Rp {{ number_format($totalToday ?? 0,0,',','.') }}</div>
        </div>

        <div class="bg-white shadow rounded-lg p-4">
            <div class="text-xs text-gray-500">Transaksi Hari Ini</div>
            <div class="mt-2 text-xl font-bold">{{ $countToday ?? 0 }}</div>
        </div>

        @if($isAdmin)
        <div class="bg-white shadow rounded-lg p-4">
            <div class="text-xs text-gray-500">Jumlah Kantin</div>
            <div class="mt-2 text-xl font-bold">{{ $kantinCount ?? '-' }}</div>
        </div>
        @else
        <div class="bg-white shadow rounded-lg p-4">
            <div class="text-xs text-gray-500">Transaksi Terbaru</div>
            <div class="mt-2 text-sm">
                @forelse($payments as $p)
                    <div class="flex justify-between py-1 border-b">
                        <span class="text-gray-700">{{ $p['nama'] }}</span>
                        <span class="text-gray-900 font-medium">Rp {{ number_format($p['total'],0,',','.') }}</span>
                    </div>
                @empty
                    <div class="text-gray-400">Tidak ada</div>
                @endforelse
            </div>
        </div>
        @endif
    </div>

    <!-- Charts + lists -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <div class="bg-white shadow rounded-lg p-4 lg:col-span-2">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-lg font-medium">Pendapatan 7 Hari Terakhir</h3>
                <div class="text-sm text-gray-500">Realtime</div>
            </div>
            <canvas id="dailyChart" height="160"></canvas>
            <div class="mt-4">
                <h4 class="text-sm font-medium mb-2">Pendapatan 6 Bulan</h4>
                <canvas id="monthlyChart" height="120"></canvas>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg p-4">
            <h3 class="text-lg font-medium mb-3">{{ $isAdmin ? 'Top Kantin (Bulan ini)' : 'Top Barang Anda' }}</h3>

            @if($isAdmin)
                @if($topKantin->isEmpty())
                    <div class="text-sm text-gray-500">Belum ada data</div>
                @else
                    <ul class="space-y-2">
                        @foreach($topKantin as $k)
                            <li class="flex justify-between items-center">
                                <div class="text-sm text-gray-700">{{ $k->kantin->nama_kantin ?? 'Kantin '.$k->kantin_id }}</div>
                                <div class="text-sm font-medium text-gray-900">Rp {{ number_format($k->revenue,0,',','.') }}</div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            @else
                @if($topItems->isEmpty())
                    <div class="text-sm text-gray-500">Belum ada data</div>
                @else
                    <ol class="list-decimal list-inside text-sm space-y-1">
                        @foreach($topItems as $it)
                            <li>{{ $it->barang->nama_barang ?? 'Barang '.$it->barang_id }} — <span class="font-medium">{{ $it->qty_sold ?? 0 }} pcs</span></li>
                        @endforeach
                    </ol>
                @endif
            @endif
        </div>
    </div>
</div>

<!-- Chart.js from CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
(() => {
    const dailyLabels = {!! json_encode($dailyLabels ?? []) !!};
    const dailyData = {!! json_encode($dailyTotals ?? []) !!};
    const monthlyLabels = {!! json_encode($monthlyLabels ?? []) !!};
    const monthlyData = {!! json_encode($monthlyTotals ?? []) !!};

    // daily chart
    const dCtx = document.getElementById('dailyChart').getContext('2d');
    new Chart(dCtx, {
        type: 'line',
        data: {
            labels: dailyLabels,
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: dailyData,
                borderColor: '#10B981',
                backgroundColor: 'rgba(16,185,129,0.08)',
                fill: true,
                tension: 0.3,
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { ticks: { callback: v => 'Rp ' + Number(v).toLocaleString('id-ID') } }
            }
        }
    });

    // monthly chart
    const mCtx = document.getElementById('monthlyChart').getContext('2d');
    new Chart(mCtx, {
        type: 'bar',
        data: {
            labels: monthlyLabels,
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: monthlyData,
                backgroundColor: '#3B82F6'
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { ticks: { callback: v => 'Rp ' + Number(v).toLocaleString('id-ID') } }
            }
        }
    });
})();
</script>
@endsection
