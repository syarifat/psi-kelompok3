@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mt-8">
    <h2 class="text-xl font-bold mb-4">Daftar Kelas</h2>

    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6 flex items-center">
        <svg class="w-6 h-6 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z" />
        </svg>
        <span>
            <strong>PERINGATAN:</strong> Jangan menghapus data kelas tanpa persetujuan developer!
            Menghapus kelas akan menghapus seluruh data siswa yang terkait di rombel kelas tersebut.
        </span>
    </div>

    <a href="{{ route('kelas.create') }}"
       class="bg-green-400 hover:bg-green-500 text-white font-semibold px-4 py-2 rounded-lg shadow transition duration-200 mb-4 inline-block">
        + Tambah Kelas
    </a>
    <table class="min-w-full border-2 border-orange-400 rounded-lg overflow-hidden shadow border-collapse">
        <thead>
            <tr class="bg-orange-500 text-white border-b-2 border-orange-400">
                <th class="px-2 py-2 font-semibold text-center w-12">No</th>
                <th class="px-4 py-2 font-semibold text-center">Nama Kelas</th>
                <th class="px-4 py-2 font-semibold text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kelas as $i => $row)
            <tr class="bg-white border-b border-orange-200 hover:bg-orange-50">
                <td class="px-2 py-2 text-center w-12">{{ $i+1 }}</td>
                <td class="px-4 py-2 text-center">{{ $row->nama }}</td>
                <td class="px-4 py-2 text-center">
                    <a href="{{ route('kelas.edit', $row) }}" class="text-blue-600">Edit</a>
                    <form action="{{ route('kelas.destroy', $row) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-pink-600 ml-2" onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
