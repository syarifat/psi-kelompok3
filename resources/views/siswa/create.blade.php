@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-8">
    <h2 class="text-xl font-bold mb-4">Tambah Siswa</h2>
    <form action="{{ route('siswa.store') }}" method="POST" class="bg-white shadow rounded-lg p-6">
        @csrf
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Nama</label>
            <input type="text" name="nama" class="w-full border rounded px-3 py-2" required value="{{ old('nama') }}">
            @error('nama')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">NIS</label>
            <input type="text" name="nis" class="w-full border rounded px-3 py-2" required value="{{ old('nis') }}">
            @error('nis')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">No HP Orang Tua</label>
            <input type="text" name="no_hp_ortu" class="w-full border rounded px-3 py-2" required value="{{ old('no_hp_ortu') }}">
            @error('no_hp_ortu')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">RFID</label>
            <input type="text" name="rfid" class="w-full border rounded px-3 py-2" required value="{{ old('rfid') }}">
            @error('rfid')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Status</label>
            <select name="status" class="w-full border rounded px-3 py-2" required>
                <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="lulus" {{ old('status') == 'lulus' ? 'selected' : '' }}>Lulus</option>
                <option value="keluar" {{ old('status') == 'keluar' ? 'selected' : '' }}>Keluar</option>
            </select>
            @error('status')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="flex justify-end mt-4">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded font-bold shadow">Simpan</button>
        </div>
    </form>
</div>
@endsection