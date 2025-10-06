@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-8">
    <h2 class="text-xl font-bold mb-4">Tambah Barang</h2>
    <form action="{{ route('barang.store') }}" method="POST" class="bg-white shadow rounded-lg p-6">
        @csrf
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Nama Barang</label>
            <input type="text" name="nama_barang" class="w-full border rounded px-3 py-2" required>
            @error('nama_barang')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Harga Barang</label>
            <input type="number" name="harga_barang" class="w-full border rounded px-3 py-2" required>
            @error('harga_barang')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
        </div>

        {{-- Admin / Superadmin pilih kantin, pemilik_kantin otomatis --}}
        @if($user->role !== 'pemilik_kantin')
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Kantin</label>
            <select name="kantin_id" class="w-full border rounded px-3 py-2" required>
                <option value="">-- Pilih Kantin --</option>
                @foreach($kantin as $k)
                    <option value="{{ $k->kantin_id }}">{{ $k->nama_kantin }}</option>
                @endforeach
            </select>
            @error('kantin_id')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
        </div>
        @endif

        <div class="flex justify-end mt-4">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded font-bold shadow">Simpan</button>
        </div>
    </form>
</div>
@endsection
