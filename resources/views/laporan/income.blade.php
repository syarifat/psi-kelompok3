@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">
            Laporan Pendapatan {{ $isAdmin ? 'Kantin' : 'Kantin Anda' }}
        </h2>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <form class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @if($isAdmin)
            <div>
                <label class="block text-sm font-medium text-gray-700">Kantin</label>
                <select name="kantin_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">Semua Kantin</option>
                    @foreach($kantins as $kantin)
                    <option value="{{ $kantin->kantin_id }}" {{ request('kantin_id') == $kantin->kantin_id ? 'selected' : '' }}>
                        {{ $kantin->nama_kantin }}
                    </option>
                    @endforeach
                </select>
            </div>
            @endif
            <div>
                <label class="block text-sm font-medium text-gray-700">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ $startDate->format('Y-m-d') }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ $endDate->format('Y-m-d') }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div class="md:col-span-3">
                <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded-md hover:bg-orange-600">
                    Terapkan Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Top Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-sm font-medium text-gray-500">Total Pendapatan</h3>
            <p class="text-2xl font-bold text-gray-900">
                Rp {{ number_format($metrics['summary']['total_income'], 0, ',', '.') }}
            </p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-sm font-medium text-gray-500">Total Transaksi</h3>
            <p class="text-2xl font-bold text-gray-900">
                {{ number_format($metrics['summary']['total_transactions'], 0) }}
            </p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-sm font-medium text-gray-500">Rata-rata Transaksi</h3>
            <p class="text-2xl font-bold text-gray-900">
                Rp {{ number_format($metrics['summary']['average_transaction'], 0, ',', '.') }}
            </p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-sm font-medium text-gray-500">Total Item Terjual</h3>
            <p class="text-2xl font-bold text-gray-900">
                {{ number_format($metrics['summary']['total_items_sold'], 0) }}
            </p>
        </div>
    </div>

    <!-- Charts and Additional Stats -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Daily Income Chart -->
        <div class="bg-white rounded-lg shadow p-6 h-[400px]">
            <h3 class="text-lg font-semibold mb-4">Tren Pendapatan Harian</h3>
            <div class="h-[300px]">
                <canvas id="dailyIncomeChart"></canvas>
            </div>
        </div>
        
        <!-- Top Products Chart -->
        <div class="bg-white rounded-lg shadow p-6 h-[400px]">
            <h3 class="text-lg font-semibold mb-4">Produk Terlaris</h3>
            <div class="h-[300px]">
                <canvas id="topProductsChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Additional Metrics in Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Most Profitable Product -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Produk Paling Menguntungkan</h3>
            @if(isset($metrics['top_products'][0]))
            <div class="space-y-2">
                <p class="text-gray-600">{{ $metrics['top_products'][0]->barang->nama_barang }}</p>
                <p class="text-2xl font-bold text-gray-900">
                    Rp {{ number_format($metrics['top_products'][0]->total_income, 0, ',', '.') }}
                </p>
                <p class="text-sm text-gray-500">
                    Terjual {{ $metrics['top_products'][0]->total_qty }} unit
                </p>
            </div>
            @endif
        </div>

        <!-- Recent Performance -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Kinerja 7 Hari Terakhir</h3>
            @php
                $recentIncome = collect($metrics['daily_income'])
                    ->take(-7)
                    ->sum('total_income');
                $recentTransactions = collect($metrics['daily_income'])
                    ->take(-7)
                    ->sum('total_transactions');
            @endphp
            <div class="space-y-2">
                <p class="text-gray-600">Total Pendapatan</p>
                <p class="text-2xl font-bold text-gray-900">
                    Rp {{ number_format($recentIncome, 0, ',', '.') }}
                </p>
                <p class="text-sm text-gray-500">
                    {{ $recentTransactions }} transaksi
                </p>
            </div>
        </div>

        <!-- Average Daily Stats -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Rata-rata Harian</h3>
            @php
                $dailyStats = collect($metrics['daily_income']);
                $avgDailyIncome = $dailyStats->average('total_income');
                $avgDailyTransactions = $dailyStats->average('total_transactions');
            @endphp
            <div class="space-y-2">
                <p class="text-gray-600">Pendapatan</p>
                <p class="text-2xl font-bold text-gray-900">
                    Rp {{ number_format($avgDailyIncome, 0, ',', '.') }}
                </p>
                <p class="text-sm text-gray-500">
                    {{ number_format($avgDailyTransactions, 1) }} transaksi/hari
                </p>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const chartConfig = {
        responsive: true,
        maintainAspectRatio: true,
        plugins: { 
            legend: { 
                position: 'top',
                labels: {
                    boxWidth: 12,
                    padding: 8
                }
            }
        }
    };

    // Daily Income Chart
    const dailyData = @json($metrics['daily_income']);
    new Chart(document.getElementById('dailyIncomeChart'), {
        type: 'line',
        data: {
            labels: dailyData.map(d => new Date(d.date).toLocaleDateString()),
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: dailyData.map(d => d.total_income),
                borderColor: 'rgb(249, 115, 22)',
                tension: 0.1
            }]
        },
        options: {
            ...chartConfig,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: value => 'Rp ' + value.toLocaleString()
                    }
                }
            }
        }
    });

    // Top Products Chart
    const productData = @json($metrics['top_products']);
    new Chart(document.getElementById('topProductsChart'), {
        type: 'bar',
        data: {
            labels: productData.map(p => p.barang.nama_barang),
            datasets: [{
                label: 'Jumlah Terjual',
                data: productData.map(p => p.total_qty),
                backgroundColor: 'rgba(249, 115, 22, 0.5)',
            }]
        },
        options: {
            ...chartConfig,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
});
</script>
@endpush
@endsection