@extends('layouts.app')
@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-xl font-bold mb-4 text-gray-700">Tambah Kantin</h2>
    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            {{ $errors->first() }}
        </div>
    @endif
    <form action="{{ route('kantin.store') }}" method="POST" class="bg-white p-6 rounded shadow-md max-w-md mx-auto">
        @csrf
        <div class="mb-4">
            <label for="nama_kantin" class="block text-gray-700 font-semibold mb-2">Nama Kantin</label>
            <input type="text" name="nama_kantin" id="nama_kantin"
                   class="border border-gray-300 rounded px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-orange-400"
                   value="{{ old('nama_kantin') }}" required>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded transition">Simpan</button>
            <a href="{{ route('kantin.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded transition">Kembali</a>
        </div>
    </form>
</div>
@endsection