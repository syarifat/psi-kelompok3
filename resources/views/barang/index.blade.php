@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-bold">Data Barang Kantin</h1>
        <a href="{{ route('barang.create') }}" 
           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow">
           + Tambah Barang
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border rounded shadow">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border">#</th>
                    <th class="px-4 py-2 border">Nama Barang</th>
                    <th class="px-4 py-2 border">Harga</th>
                    <th class="px-4 py-2 border">Kantin</th>
                    <th class="px-4 py-2 border text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($barang as $index => $b)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border text-center">{{ $index + 1 }}</td>
                    <td class="px-4 py-2 border">{{ $b->nama_barang }}</td>
                    <td class="px-4 py-2 border">Rp {{ number_format($b->harga_barang, 0, ',', '.') }}</td>
                    <td class="px-4 py-2 border">{{ $b->kantin->nama_kantin ?? '-' }}</td>
                    <td class="px-4 py-2 border text-center">
                        <a href="{{ route('barang.edit', $b->barang_id) }}" 
                           class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded shadow mr-1">
                           Edit
                        </a>
                        <form action="{{ route('barang.destroy', $b->barang_id) }}" method="POST" class="inline-block" 
                              onsubmit="return confirm('Yakin hapus barang ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded shadow">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-gray-500">Belum ada data barang</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
