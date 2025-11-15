@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-2xl py-8">
    <div class="bg-orange-500 px-6 py-5 rounded-t-lg flex justify-center items-center">
        <svg class="h-7 w-7 text-white mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18v4H3V3zm0 8h18v10H3V11z"/>
        </svg>
        <span class="text-2xl font-bold text-white leading-tight text-center">Histori Transaksi</span>
    </div>

    <!-- Info Siswa -->
    <div class="px-6 py-4 bg-orange-50 border-b">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <p class="text-sm text-gray-600">Nama</p>
                <h3 class="text-lg font-semibold text-gray-900">{{ $siswa->nama ?? '-' }}</h3>
            </div>
            <div>
                <p class="text-sm text-gray-600">NIS</p>
                <h3 class="text-lg font-semibold text-gray-900">{{ $siswa->nis ?? '-' }}</h3>
            </div>
            <div>
                <p class="text-sm text-gray-600">Saldo Saat Ini</p>
                <h3 class="text-lg font-semibold text-gray-900">Rp. {{ number_format($siswa->saldo->saldo ?? 0, 0, '', '.') }}</h3>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="px-6 py-6">
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg shadow">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Tanggal</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Items</th>
                        <th class="px-4 py-3 text-right text-sm font-medium text-gray-600">Total</th>
                        <th class="px-4 py-3 text-center text-sm font-medium text-gray-600">Status</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Kantin</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transaksi as $t)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm text-gray-700">
                            {{ $t->created_at ? \Carbon\Carbon::parse($t->created_at)->format('d M Y H:i') : '-' }}
                        </td>

                        <td class="px-4 py-3 text-sm text-gray-900">
                            <div class="space-y-1">
                                @php
                                    // fallback: transaksiItems relation atau items array (jika controller men-transform)
                                    $items = null;
                                    if(isset($t->transaksiItems)) {
                                        $items = $t->transaksiItems;
                                    } elseif(isset($t->items)) {
                                        $items = collect($t->items);
                                    }
                                @endphp

                                @if($items && $items->count())
                                    @foreach($items as $it)
                                        @php
                                            $nama = $it->barang->nama_barang ?? $it->barang->nama ?? ($it->nama_barang ?? '-');
                                            $qty = $it->jumlah ?? $it->qty ?? 0;
                                            $subtotal = $it->subtotal ?? ($qty * ($it->harga ?? $it->harga_satuan ?? 0));
                                        @endphp
                                        <div>
                                            {{ $nama }} × {{ $qty }} (Rp {{ number_format($subtotal, 0, ',', '.') }})
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-gray-500">-</div>
                                @endif
                            </div>
                        </td>

                        <td class="px-4 py-3 text-right text-sm font-semibold text-gray-900">
                            @php
                                $total = $t->total_harga ?? $t->total ?? $t->amount ?? 0;
                            @endphp
                            Rp {{ number_format($total, 0, ',', '.') }}
                        </td>

                        <td class="px-4 py-3 text-center text-sm">
                            @php $st = strtolower($t->status ?? ''); @endphp
                            @if(in_array($st, ['paid', 'success']))
                                <span class="text-green-700 bg-green-100 px-2 py-1 rounded-full text-xs">Berhasil</span>
                            @elseif($st === 'pending')
                                <span class="text-yellow-700 bg-yellow-100 px-2 py-1 rounded-full text-xs">Pending</span>
                            @elseif(in_array($st, ['failed', 'fail', 'cancelled']))
                                <span class="text-red-700 bg-red-100 px-2 py-1 rounded-full text-xs">Gagal</span>
                            @else
                                <span class="text-gray-600 bg-gray-100 px-2 py-1 rounded-full text-xs">{{ strtoupper($st ?: 'UNKNOWN') }}</span>
                            @endif
                        </td>

                        <td class="px-4 py-3 text-sm text-gray-700">
                            {{ $t->kantin->nama_kantin ?? $t->kantin->nama ?? '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                            Tidak ada transaksi.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection