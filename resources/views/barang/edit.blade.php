@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-8">
    <h2 class="text-xl font-bold mb-4">Edit Barang</h2>

    <form action="{{ route('barang.update', $barang->barang_id) }}" method="POST" class="bg-white shadow rounded-lg p-6">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Nama Barang</label>
            <input type="text" name="nama_barang" class="w-full border rounded px-3 py-2"
                   value="{{ old('nama_barang', $barang->nama_barang) }}" required>
            @error('nama_barang')
                <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Harga Barang</label>
            <input type="number" name="harga_barang" class="w-full border rounded px-3 py-2"
                   value="{{ old('harga_barang', $barang->harga_barang) }}" step="100" required>
            @error('harga_barang')
                <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror
        </div>

        @if(Auth::user()->role !== 'pemilik_kantin')
            <div class="mb-4">
                <label class="block mb-1 font-semibold">Kantin</label>
                <input type="text" class="w-full border rounded px-3 py-2 bg-gray-100"
                       value="{{ $barang->kantin->nama_kantin ?? '-' }}" disabled>
            </div>
        @endif

        <div class="flex justify-end mt-4">
            <a href="{{ route('barang.index') }}"
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded font-bold shadow mr-2">
                Batal
            </a>
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded font-bold shadow">
                Update
            </button>
        </div>
    </form>
</div>
@endsection
