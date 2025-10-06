@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-xl font-bold mb-4 text-gray-700">Data Kantin</h1>
    <a href="{{ route('kantin.create') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded mb-4 inline-block transition">+ Tambah Kantin</a>
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Kantin</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal Dibuat</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($kantins as $kantin)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $kantin->nama_kantin }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-500 text-sm">{{ $kantin->created_at->format('d M Y, H:i') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                        {{-- Menggunakan $kantin->kantin_id agar lebih eksplisit --}}
                        <a href="{{ route('kantin.edit', $kantin->kantin_id) }}" class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded text-sm transition">Edit</a>
                        <form action="{{ route('kantin.destroy', $kantin->kantin_id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus kantin ini?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm transition">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                        Belum ada data kantin.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
