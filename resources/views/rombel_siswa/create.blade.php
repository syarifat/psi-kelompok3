@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto mt-8">
    <h2 class="text-xl font-bold mb-4">Tambah Rombel Siswa</h2>
    <form method="POST" action="{{ route('rombel_siswa.mass_store') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block mb-2">Pilih Siswa</label>
            <div class="border rounded px-2 py-1 bg-white overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-2 py-1 text-center">
                                <input type="checkbox" id="checkAll" onclick="toggleAll(this)">
                            </th>
                            <th class="px-2 py-1 text-center">NIS</th>
                            <th class="px-2 py-1 text-left">Nama</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($siswa as $row)
                        <tr>
                            <td class="px-2 py-1 text-center">
                                <input type="checkbox" name="siswa_id[]" value="{{ $row->id }}" class="siswa-check">
                            </td>
                            <td class="px-2 py-1 text-center">{{ $row->nis }}</td>
                            <td class="px-2 py-1 text-left">{{ $row->nama }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div>
            <label class="block mb-2">Kelas</label>
            <select name="kelas_id" class="border rounded px-2 py-1 w-full" required>
                <option value="">- Pilih Kelas -</option>
                @foreach($kelas as $row)
                <option value="{{ $row->id }}">{{ $row->nama }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block mb-2">Tahun Ajaran</label>
            <input type="hidden" name="tahun_ajaran_id" value="{{ $tahunAjaran->id }}">
            <div class="border rounded px-2 py-1 w-full bg-gray-100 text-gray-700">
                {{ $tahunAjaran->nama }}
            </div>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Masukkan ke Kelas</button>
    </form>
</div>
<script>
function toggleAll(source) {
    document.querySelectorAll('.siswa-check').forEach(cb => cb.checked = source.checked);
}
</script>
@endsection
