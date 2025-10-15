@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-8">
    <h2 class="text-xl font-bold mb-4">Top Up Saldo Siswa</h2>

    <!-- Card Siswa -->
    <div id="siswa-card" class="bg-orange-50 border border-orange-200 rounded-lg p-4 mb-4 flex justify-between items-center">
        <div>
            <div class="text-lg font-bold text-orange-700" id="nama-siswa">-</div>
            <div class="text-xs text-gray-500">NIS: <span id="nis-siswa">-</span></div>
        </div>
        <div id="saldo-section" style="display:none;">
            <div class="text-base font-bold text-green-700 text-right">Saldo Sekarang</div>
            <div class="text-2xl font-extrabold text-green-600 text-right" id="saldo-siswa">Rp 0</div>
        </div>
    </div>

    <!-- Alert Top Up -->
    <div id="topup-alert" style="display:none;" class="mb-4"></div>

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
                {{-- <th class="px-4 py-2 border text-center">Created At</th> --}}
            </tr>
        </thead>
        <tbody>
            @forelse($historiAll as $row)
            <tr>
                <td class="px-4 py-2 border text-center">{{ $row->topup_id ?? $row->id }}</td>
                <td class="px-4 py-2 border text-center">{{ $row->siswa->nama ?? '-' }}</td>
                <td class="px-4 py-2 border text-center">Rp. {{ number_format($row->nominal, 0, '', '.') }}</td>
                <td class="px-4 py-2 border text-center">{{ $row->waktu }}</td>
                {{-- <td class="px-4 py-2 border text-center">{{ $row->created_at }}</td> --}}
            </tr>
            @empty
            <tr>
                <td class="px-4 py-2 border text-center" colspan="5">Belum ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Popup Alert -->
<div id="topup-popup" class="fixed inset-0 flex items-center justify-center z-50 hidden">
    <!-- Backdrop kuning solid -->
    <div class="absolute inset-0 bg-yellow-300/90"></div>
    <!-- Popup Content -->
    <div id="popup-content"
        class="relative flex flex-col items-center justify-center bg-white rounded-3xl shadow-2xl border-4 border-yellow-400 px-12 py-10 w-[350px] md:w-[420px] scale-0 opacity-0 transition-transform transition-opacity duration-500 z-10">
        <!-- Success Icon -->
        <div class="bg-yellow-400 rounded-full p-4 shadow-lg mb-6 animate-bounce">
            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10" stroke="white" stroke-width="3" fill="none"/>
                <path stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" d="M7 13l3 3 7-7"/>
            </svg>
        </div>
        <!-- Message -->
        <h3 id="popup-message" class="text-yellow-700 text-2xl font-extrabold mb-2 text-center drop-shadow-lg"></h3>
        <p class="text-gray-700 text-lg mb-6 text-center font-semibold">Saldo berhasil ditambahkan ke akun siswa!</p>
        <button id="popup-close"
            class="bg-yellow-400 hover:bg-yellow-500 text-white font-bold px-8 py-3 rounded-xl shadow-lg transition-all duration-300 text-lg">
            TUTUP
        </button>
    </div>
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
                // Tampilkan saldo sesuai database
                document.getElementById('saldo-siswa').textContent = "Rp " + (data.siswa.saldo ? Number(data.siswa.saldo).toLocaleString() : "0");
                document.getElementById('saldo-section').style.display = 'block';
                document.getElementById('topup-form').style.display = 'block';
            } else {
                document.getElementById('nama-siswa').textContent = '-';
                document.getElementById('nis-siswa').textContent = '-';
                document.getElementById('saldo-section').style.display = 'none';
                document.getElementById('topup-form').style.display = 'none';
            }
        });
}
window.addEventListener('DOMContentLoaded', function() {
    fetch('/api/topup/reset', { method: 'POST' });
    fetchSiswaTopup();
});
setInterval(fetchSiswaTopup, 3000);

function showPopup(message, type = 'success') {
    const popup = document.getElementById('topup-popup');
    const content = document.getElementById('popup-content');
    const msg = document.getElementById('popup-message');
    const closeBtn = document.getElementById('popup-close');

    msg.textContent = message;
    
    // Show popup with animation
    popup.style.display = 'flex';
    setTimeout(() => {
        content.classList.remove('scale-0', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    }, 10);

    // Auto close after 3 seconds
    let autoClose = setTimeout(() => {
        hidePopup();
    }, 3000);

    // Manual close
    closeBtn.onclick = function() {
        clearTimeout(autoClose);
        hidePopup();
    };
}

function hidePopup() {
    const popup = document.getElementById('topup-popup');
    const content = document.getElementById('popup-content');
    
    content.classList.remove('scale-100', 'opacity-100');
    content.classList.add('scale-0', 'opacity-0');
    
    setTimeout(() => {
        popup.style.display = 'none';
    }, 500);
}

document.getElementById('topup-form').addEventListener('submit', function(e) {
    e.preventDefault();
    var siswa_id = document.getElementById('siswa_id').value;
    var nominal = document.getElementById('nominal').value;
    fetch("/api/topup/store", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ siswa_id, nominal })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            showPopup('Berhasil top up saldo!', 'success');
            // Reset cache siswa setelah popup hilang
            setTimeout(() => {
                fetch('/api/topup/reset', { method: 'POST' }).then(() => {
                    fetchSiswaTopup();
                });
            }, 3000);
        } else {
            showPopup('Top up gagal: ' + (data.message || 'Terjadi kesalahan'), 'error');
        }
    })
    .catch(err => {
        showPopup('Top up gagal: ' + err, 'error');
    });
});
</script>

<!-- Add these custom animations to your CSS -->
<style>
    @keyframes checkmark {
        0% { stroke-dasharray: 0,28; }
        100% { stroke-dasharray: 28,28; }
    }
    @keyframes bounceIn {
        0% { transform: scale(0); }
        50% { transform: scale(1.2); }
        100% { transform: scale(1); }
    }
    .animate-checkmark {
        stroke-dasharray: 28,28;
        animation: checkmark 0.8s ease-in-out forwards;
    }
    .animate-bounceIn {
        animation: bounceIn 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }
    .animate-fadeInUp {
        animation: fadeInUp 0.5s ease-out forwards;
    }
    .animation-delay-200 {
        animation-delay: 0.2s;
    }
    .animation-delay-300 {
        animation-delay: 0.3s;
    }
    .animation-delay-400 {
        animation-delay: 0.4s;
    }
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endsection