@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">
            Detail Transaksi {{ $isAdmin ? 'Semua Kantin' : 'Kantin Anda' }}
        </h2>
    </div>

    <!-- Advanced Filters -->
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
                <input type="date" name="start_date" value="{{ request('start_date') }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Minimal Total</label>
                <input type="number" name="min_amount" value="{{ request('min_amount') }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                    placeholder="Rp">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Maksimal Total</label>
                <input type="number" name="max_amount" value="{{ request('max_amount') }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                    placeholder="Rp">
            </div>
            <div class="md:col-span-3 flex gap-2">
                <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded-md hover:bg-orange-600">
                    Terapkan Filter
                </button>
                <a href="{{ route('laporan.transaksi.export') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                    Export Excel
                </a>
            </div>
        </form>
    </div>

    <!-- Transactions Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Tanggal
                    </th>
                    @if($isAdmin)
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Kantin
                    </th>
                    @endif
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Siswa
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Items
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Total
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($transaksis as $transaksi)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $transaksi->created_at->format('d/m/Y H:i') }}
                    </td>
                    @if($isAdmin)
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $transaksi->kantin->nama_kantin }}
                    </td>
                    @endif
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $transaksi->siswa->nama }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        <div class="space-y-1">
                            @foreach($transaksi->items as $item)
                            <div>
                                {{ $item->barang->nama_barang }} × {{ $item->qty }}
                                (Rp {{ number_format($item->subtotal, 0, ',', '.') }})
                            </div>
                            @endforeach
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                        Rp {{ number_format($transaksi->total, 0, ',', '.') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-6 py-4 border-t">
            {{ $transaksis->links() }}
        </div>
    </div>
</div>
@endsection