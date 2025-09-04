@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto mt-8">
    <h2 class="text-xl font-bold mb-4">Rekap Absensi Siswa</h2>
    <div class="mb-6 flex flex-wrap gap-4 items-center">
        <!-- Search Box -->
        <div class="relative">
            <input type="text" id="search" placeholder="Masukkan nama atau nis"
                class="border-2 border-gray-300 rounded-lg pl-10 pr-4 py-2 w-64
                       focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400
                       transition duration-200 shadow-sm"
                autofocus>
            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
                </svg>
            </span>
        </div>
        <!-- Filter Tanggal -->
        <div class="relative">
            <input type="date" id="tanggal"
                class="border-2 border-gray-300 rounded-lg px-4 py-2 w-48
                       focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400
                       transition duration-200 shadow-sm text-gray-700">
        </div>
        <!-- Dropdown Kelas -->
        <div class="relative">
            <select id="kelas_id"
                class="border-2 border-gray-300 rounded-lg pl-10 pr-4 py-2 w-48
                       focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400
                       transition duration-200 shadow-sm bg-gray-50 text-gray-700 font-semibold appearance-none">
                <option value="">-- Pilih Kelas --</option>
                @foreach(\App\Models\Kelas::all() as $kelas)
                    <option value="{{ $kelas->id }}">{{ $kelas->nama }}</option>
                @endforeach
            </select>
            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </span>
        </div>
    </div>
    <div class="flex justify-end mb-4">
        <div class="relative inline-block text-left">
            <button type="button" class="bg-pink-400 hover:bg-pink-500 text-white font-semibold px-4 py-2 rounded-lg shadow transition duration-200 focus:outline-none"
                onclick="document.getElementById('exportDropdown').classList.toggle('hidden')">
                Export <svg class="inline h-4 w-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
            </button>
            <div id="exportDropdown" class="absolute right-0 mt-2 w-40 bg-white border border-pink-300 rounded-lg shadow-lg z-10 hidden">
                <a href="{{ route('absensi.export', ['type' => 'pdf']) }}" class="block px-4 py-2 text-pink-700 hover:bg-pink-100 hover:text-pink-900 transition">Export PDF</a>
                <a href="{{ route('absensi.export', ['type' => 'excel']) }}" class="block px-4 py-2 text-pink-700 hover:bg-pink-100 hover:text-pink-900 transition">Export Excel</a>
            </div>
        </div>
    </div>
    <table class="min-w-full border-2 border-orange-400 rounded-lg overflow-hidden shadow">
        <thead>
            <tr class="bg-orange-500 text-white">
                <th class="px-4 py-2 border-orange-400">No</th>
                <th class="px-4 py-2 border-orange-400">Nama</th>
                <th class="px-4 py-2 border-orange-400">NIS</th>
                <th class="px-4 py-2 border-orange-400">Kelas</th> <!-- Tambahkan ini -->
                <th class="px-4 py-2 border-orange-400">Tanggal</th>
                <th class="px-4 py-2 border-orange-400">Jam</th>
                <th class="px-4 py-2 border-orange-400">Status</th>
                <th class="px-4 py-2 border-orange-400">Keterangan</th>
                <th class="px-4 py-2 border-orange-400">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($absensi as $i => $row)
            <tr class="bg-white border-b border-orange-200 hover:bg-orange-50">
                <td class="px-4 py-2 border-orange-200">{{ $i+1 }}</td>
                <td class="px-4 py-2 border-orange-200">{{ $row->siswa->nama ?? '-' }}</td>
                <td class="px-4 py-2 border-orange-200">
                    {{ $row->rombel && $row->rombel->siswa ? $row->rombel->siswa->nis : '-' }}
                </td>
                <td class="px-4 py-2 border-orange-200">
                    {{ $row->rombel && $row->rombel->kelas ? $row->rombel->kelas->nama : '-' }}
                </td>
                <td class="px-4 py-2 border-orange-200">{{ $row->tanggal }}</td>
                <td class="px-4 py-2 border-orange-200">{{ $row->jam }}</td>
                <td class="px-4 py-2 border-orange-200">{{ $row->status }}</td>
                <td class="px-4 py-2 border-orange-200">{{ $row->keterangan ?? '-' }}</td>
                <td class="px-4 py-2 border-orange-200">
                    <a href="{{ route('absensi.show', $row) }}" class="text-blue-600">Detail</a>
                    <a href="{{ route('absensi.edit', $row) }}" class="text-pink-600 ml-2">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
<script>
function fetchAbsensi() {
    const search = document.getElementById('search').value;
    const tanggal = document.getElementById('tanggal').value;
    const kelas_id = document.getElementById('kelas_id').value;
    let url = `/api/absensi-terbaru?search=${encodeURIComponent(search)}&tanggal=${encodeURIComponent(tanggal)}&kelas_id=${encodeURIComponent(kelas_id)}`;
    fetch(url)
        .then(res => res.json())
        .then(data => {
            let tbody = '';
            data.forEach((row, i) => {
                tbody += `<tr class="bg-white border-b border-orange-200 hover:bg-orange-50">
                    <td class="px-4 py-2 border-orange-200">${i+1}</td>
                    <td class="px-4 py-2 border-orange-200">${row.siswa_nama ?? '-'}</td>
                    <td class="px-4 py-2 border-orange-200">${row.siswa_nis ?? '-'}</td>
                    <td class="px-4 py-2 border-orange-200">${row.kelas_nama ?? '-'}</td> <!-- Tambahkan ini -->
                    <td class="px-4 py-2 border-orange-200">${row.tanggal ?? '-'}</td>
                    <td class="px-4 py-2 border-orange-200">${row.jam ?? '-'}</td>
                    <td class="px-4 py-2 border-orange-200">${row.status ?? '-'}</td>
                    <td class="px-4 py-2 border-orange-200">${row.keterangan ?? '-'}</td>
                    <td class="px-4 py-2 border-orange-200">
                        <a href="/absensi/${row.id}" class="text-blue-600">Detail</a>
                        <a href="/absensi/${row.id}/edit" class="text-pink-600 ml-2">Edit</a>
                    </td>
                </tr>`;
            });
            document.querySelector('tbody').innerHTML = tbody;
        });
}
document.getElementById('search').addEventListener('input', fetchAbsensi);
document.getElementById('tanggal').addEventListener('change', fetchAbsensi);
document.getElementById('kelas_id').addEventListener('change', fetchAbsensi);
setInterval(fetchAbsensi, 3000);
window.addEventListener('DOMContentLoaded', fetchAbsensi);
</script>
<script>
    // Tutup dropdown jika klik di luar
    document.addEventListener('click', function(e) {
        const btn = document.querySelector('button[onclick]');
        const dropdown = document.getElementById('exportDropdown');
        if (!btn.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.add('hidden');
        }
    });
</script>
@endsection
