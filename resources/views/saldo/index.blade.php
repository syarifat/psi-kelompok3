@extends('layouts.app')
@section('content')
<div class="max-w-4xl mx-auto mt-8">
    <h2 class="text-xl font-bold mb-4">Data Saldo Siswa</h2>
    
    <!-- Search Box -->
    <div class="relative mb-4">
        <input type="text" id="search" placeholder="Cari nama atau NIS"
            class="border-2 border-gray-300 rounded-lg pl-10 pr-4 py-2 w-64
                   focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400
                   transition duration-200 shadow-sm"
        >
        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
            </svg>
        </span>
    </div>

    <table class="min-w-full border-2 border-orange-400 rounded-lg overflow-hidden shadow border-collapse">
        <thead>
            <tr class="bg-orange-500 text-white border-b-2 border-orange-400">
                <th class="px-4 py-2 text-left font-semibold">Nama Siswa</th>
                <th class="px-4 py-2 text-center font-semibold">NIS</th>
                <th class="px-4 py-2 text-center font-semibold">Saldo</th>
                <th class="px-4 py-2 text-center font-semibold">Histori Topup</th>
            </tr>
        </thead>
        <tbody id="saldo-tbody">
            @foreach($saldos as $i => $saldo)
            <tr class="{{ $i % 2 == 0 ? 'bg-white' : 'bg-gray-100' }} border-b border-orange-200 hover:bg-orange-50">
                <td class="px-4 py-2 text-left">{{ $saldo->siswa->nama ?? '-' }}</td>
                <td class="px-4 py-2 text-center">{{ $saldo->siswa->nis ?? '-' }}</td>
                <td class="px-4 py-2 text-center">Rp. {{ number_format($saldo->saldo, 0, '', '.') }}</td>
                <td class="px-4 py-2 text-center">
                    <a href="{{ route('siswa.topup.histori', ['siswa_id' => $saldo->siswa->id]) }}"
                       class="inline-block bg-orange-500 hover:bg-orange-600 text-white font-semibold px-4 py-2 rounded transition duration-150 shadow">
                        Lihat Histori
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
<script>
function fetchSaldo() {
    const search = document.getElementById('search').value;
    fetch(`/api/saldo?search=${encodeURIComponent(search)}`)
        .then(res => res.json())
        .then(data => {
            let tbody = '';
            data.forEach((saldo, i) => {
                tbody += `
                    <tr class="${i % 2 == 0 ? 'bg-white' : 'bg-gray-100'} border-b border-orange-200 hover:bg-orange-50">
                        <td class="px-4 py-2 text-left">${saldo.siswa?.nama ?? '-'}</td>
                        <td class="px-4 py-2 text-center">${saldo.siswa?.nis ?? '-'}</td>
                        <td class="px-4 py-2 text-center">Rp. ${Number(saldo.saldo).toLocaleString('id-ID')}</td>
                        <td class="px-4 py-2 text-center">
                            <a href="/siswa/${saldo.siswa_id}/topup/histori"
                               class="inline-block bg-orange-500 hover:bg-orange-600 text-white font-semibold px-4 py-2 rounded transition duration-150 shadow">
                                Lihat Histori
                            </a>
                        </td>
                    </tr>
                `;
            });
            document.getElementById('saldo-tbody').innerHTML = tbody;
        });
}

let typingTimer;
const doneTypingInterval = 500;

document.getElementById('search').addEventListener('input', () => {
    clearTimeout(typingTimer);
    typingTimer = setTimeout(fetchSaldo, doneTypingInterval);
});
</script>
@endsection
