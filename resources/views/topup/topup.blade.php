@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-8">
    <h2 class="text-xl font-bold mb-4">Top Up Saldo Siswa</h2>

    <!-- Card Siswa -->
    <div id="siswa-card" class="bg-orange-50 border border-orange-200 rounded-lg p-4 mb-4">
        <div class="text-lg font-bold text-orange-700" id="nama-siswa">-</div>
        <div class="text-xs text-gray-500">NIS: <span id="nis-siswa">-</span></div>
    </div>

    <!-- Form Top Up -->
    <form id="topup-form" action="{{ route('pos.topup.store') }}" method="POST" style="display:none;">
        @csrf
        <input type="hidden" name="siswa_id" id="siswa_id">
        <div class="mb-4">
            <label for="nominal" class="block font-semibold mb-1 text-gray-700">Nominal Top Up</label>
            <input type="number" name="nominal" id="nominal" min="1000" required placeholder="Masukkan nominal top up"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400">
        </div>
        <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded transition">Top Up</button>
    </form>
</div>

<!-- Tambahan: Tabel Histori -->
<div class="max-w-3xl mx-auto mt-12">
    <h2 class="text-xl font-bold mb-4">Histori Top Up Seluruh Siswa</h2>
    <table class="min-w-full bg-white border rounded shadow">
        <thead>
            <tr class="bg-orange-100">
                <th class="px-4 py-2 border text-center">ID</th>
                <th class="px-4 py-2 border text-center">Nama Siswa</th>
                <th class="px-4 py-2 border text-center">Nominal</th>
                <th class="px-4 py-2 border text-center">Waktu</th>
                <th class="px-4 py-2 border text-center">Created At</th>
            </tr>
        </thead>
        <tbody>
            @forelse($historiAll as $row)
            <tr>
                <td class="px-4 py-2 border text-center">{{ $row->topup_id ?? $row->id }}</td>
                <td class="px-4 py-2 border text-center">{{ $row->siswa->nama ?? '-' }}</td>
                <td class="px-4 py-2 border text-center">Rp. {{ number_format($row->nominal, 0, '', '.') }}</td>
                <td class="px-4 py-2 border text-center">{{ $row->waktu }}</td>
                <td class="px-4 py-2 border text-center">{{ $row->created_at }}</td>
            </tr>
            @empty
            <tr>
                <td class="px-4 py-2 border text-center" colspan="5">Belum ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
<script>
function fetchSiswaTopup() {
    fetch('/api/topup/current')
        .then(res => res.json())
        .then(data => {
            if (data.siswa) {
                document.getElementById('nama-siswa').textContent = data.siswa.nama;
                document.getElementById('nis-siswa').textContent = data.siswa.nis;
                document.getElementById('siswa_id').value = data.siswa.id;
                document.getElementById('topup-form').style.display = 'block';
            } else {
                document.getElementById('nama-siswa').textContent = '-';
                document.getElementById('nis-siswa').textContent = '-';
                document.getElementById('topup-form').style.display = 'none';
            }
        });
}
window.addEventListener('DOMContentLoaded', function() {
    fetch('/api/topup/reset', { method: 'POST' });
    fetchSiswaTopup();
});
setInterval(fetchSiswaTopup, 3000);
</script>
@endsection
