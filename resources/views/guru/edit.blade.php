@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto mt-8">
    <h2 class="text-xl font-bold mb-4">Edit Guru</h2>
    <form method="POST" action="{{ route('guru.update', $guru) }}" class="space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label class="block">Nama</label>
            <input type="text" name="nama" value="{{ $guru->nama }}" class="border rounded px-2 py-1 w-full" required>
        </div>
        <div>
            <label class="block">NIP</label>
            <input type="text" name="nip" value="{{ $guru->nip }}" class="border rounded px-2 py-1 w-full">
        </div>
        <div>
            <label class="block">No HP</label>
            <input type="text" name="no_hp" value="{{ $guru->no_hp }}" class="border rounded px-2 py-1 w-full">
        </div>
        <div>
            <label class="block">Email</label>
            <input type="email" name="email" value="{{ $guru->email }}" class="border rounded px-2 py-1 w-full">
        </div>
        <div>
            <label class="block">Alamat</label>
            <textarea name="alamat" class="border rounded px-2 py-1 w-full">{{ $guru->alamat }}</textarea>
        </div>
        <div>
            <label class="block">Status</label>
            <select name="status" class="border rounded px-2 py-1 w-full">
                <option value="aktif" @if($guru->status=='aktif') selected @endif>Aktif</option>
                <option value="tidak aktif" @if($guru->status=='tidak aktif') selected @endif>Tidak Aktif</option>
            </select>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
    </form>
</div>
@endsection
