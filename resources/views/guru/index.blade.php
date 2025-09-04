@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto mt-8">
    <h2 class="text-xl font-bold mb-4">Data Guru</h2>
    <a href="{{ route('guru.create') }}" class="bg-green-400 hover:bg-green-500 text-white font-semibold px-4 py-2 rounded-lg shadow transition duration-200 mb-4 inline-block">
        Tambah Guru
    </a>
    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="w-full min-w-[900px] border-2 border-orange-400 rounded-lg overflow-hidden border-collapse">
            <thead>
                <tr class="bg-orange-500 text-white border-b-2 border-orange-400 rounded-none">
                    <th class="px-4 py-2 text-center font-semibold">ID</th>
                    <th class="px-4 py-2 text-left font-semibold">Nama</th>
                    <th class="px-4 py-2 text-center font-semibold">NIP</th>
                    <th class="px-4 py-2 text-center font-semibold">No HP</th>
                    <th class="px-4 py-2 text-left font-semibold">Email</th>
                    <th class="px-4 py-2 text-left font-semibold">Alamat</th>
                    <th class="px-4 py-2 text-center font-semibold">Status</th>
                    <th class="px-4 py-2 text-center font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($guru as $i => $row)
                <tr class="{{ $i % 2 == 0 ? 'bg-white' : 'bg-gray-100' }} border-b border-orange-200 hover:bg-orange-50">
                    <td class="px-4 py-2 text-center">{{ $row->id }}</td>
                    <td class="px-4 py-2 text-left">{{ $row->nama }}</td>
                    <td class="px-4 py-2 text-center">{{ $row->nip }}</td>
                    <td class="px-4 py-2 text-center">{{ $row->no_hp }}</td>
                    <td class="px-4 py-2 text-left">{{ $row->email }}</td>
                    <td class="px-4 py-2 text-left">{{ $row->alamat }}</td>
                    <td class="px-4 py-2 text-center">{{ $row->status }}</td>
                    <td class="px-4 py-2 text-center">
                        <a href="{{ route('guru.edit', $row) }}" class="text-blue-600">Edit</a>
                        <form action="{{ route('guru.destroy', $row) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-pink-600 ml-2" onclick="return confirm('Hapus guru ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
