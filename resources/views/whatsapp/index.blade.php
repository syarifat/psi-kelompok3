@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto mt-8">
    <div class="bg-white shadow rounded-lg p-8">
        <h2 class="text-2xl font-bold mb-4 text-orange-500 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.72 11.06a4.5 4.5 0 01-6.36 6.36l-2.12.71a1 1 0 01-1.27-1.27l.71-2.12a4.5 4.5 0 016.36-6.36z" />
            </svg>
            Broadcast WhatsApp
        </h2>
        @if(session('error'))
            <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif
        @if(session('success'))
            <div class="bg-orange-100 text-orange-800 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        <form method="POST" action="{{ route('whatsapp.send') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block font-semibold mb-1 text-orange-700">Tipe Kirim</label>
                <select name="tipe" id="tipe" class="border-2 border-gray-300 rounded-lg px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400 transition duration-200 bg-gray-50 text-gray-700 font-semibold" onchange="toggleForm()">
                    <option value="semua">Broadcast Semua Wali Siswa</option>
                    <option value="kelas">Per Kelas</option>
                    <option value="individu">Individu</option>
                </select>
            </div>
            <div id="kelasForm" style="display:none;">
                <label class="block font-semibold mb-1 text-orange-700">Pilih Kelas</label>
                <select name="kelas_id" class="border-2 border-gray-300 rounded-lg px-4 py-2 w-full bg-gray-50 text-gray-700 font-semibold focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400 transition duration-200">
                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}">{{ $k->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div id="individuForm" style="display:none;">
                <label class="block font-semibold mb-1 text-orange-700">Pilih Siswa</label>
                <select name="no_hp_ortu" class="border-2 border-gray-300 rounded-lg px-4 py-2 w-full bg-gray-50 text-gray-700 font-semibold focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400 transition duration-200">
                    @foreach($siswa as $s)
                        <option value="{{ $s->no_hp_ortu }}">{{ $s->nama }} ({{ $s->nis }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block font-semibold mb-1 text-orange-700">Pesan</label>
                <textarea name="pesan" class="border-2 border-gray-300 rounded-lg px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400 transition duration-200 shadow-sm text-gray-700 bg-gray-50" rows="4" required></textarea>
            </div>
            <button type="submit" class="bg-yellow-400 hover:bg-yellow-500 text-orange-900 font-bold px-6 py-2 rounded-lg shadow transition duration-200 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-orange-700" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M21.75 3.75a.75.75 0 0 0-.75-.75H3a.75.75 0 0 0-.75.75v16.5a.75.75 0 0 0 .75.75h18a.75.75 0 0 0 .75-.75V3.75zm-2.47 4.22-2.7 10.8a.75.75 0 0 1-1.17.43l-3.13-2.36-1.51 1.46a.75.75 0 0 1-1.27-.44l-.38-2.52-2.52-.38a.75.75 0 0 1-.44-1.27l1.46-1.51-2.36-3.13a.75.75 0 0 1 .43-1.17l10.8-2.7a.75.75 0 0 1 .92.92z"/>
                </svg>
                Kirim Pesan
            </button>
        </form>
    </div>
</div>
<script>
function toggleForm() {
    var tipe = document.getElementById('tipe').value;
    document.getElementById('kelasForm').style.display = tipe === 'kelas' ? '' : 'none';
    document.getElementById('individuForm').style.display = tipe === 'individu' ? '' : 'none';
}
document.addEventListener('DOMContentLoaded', toggleForm);
</script>
@endsection