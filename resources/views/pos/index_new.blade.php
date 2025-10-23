@extends('layouts.app')
@section('content')
{{-- Latar belakang utama --}}
<div class="flex h-screen bg-gray-50 overflow-hidden">

    {{-- Kolom Kiri: Daftar Menu --}}
    <div class="flex-1 flex flex-col p-6 overflow-hidden">
        <div class="mb-6">
            <h2 class="text-3xl font-bold text-gray-800">Transaksi Kantin</h2>
            <p class="text-gray-500">Pilih menu untuk memulai transaksi</p>
        </div>

        {{-- Notifikasi --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">{{ session('error') }}</div>
        @endif

        {{-- Pencarian Menu --}}
        <div class="mb-6">
            <div class="relative">
                <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" id="search-menu" placeholder="Cari menu makanan..." class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent shadow-sm">
            </div>
        </div>

        {{-- Kontainer Menu (Grid) --}}
        <div class="flex-1 overflow-y-auto pr-2">
            <div id="menu-container" class="flex flex-wrap gap-4">
                @forelse($barangList as $barang)
                <div class="menu-item flex flex-col w-[calc((100%-4rem)/5)]">
                    {{-- [DISEMPURNAKAN] Kartu dibuat sebagai tombol untuk aksesibilitas yang lebih baik --}}
                    <button type="button" class="bg-white rounded-lg shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden group border border-gray-100 flex-grow flex flex-col text-left" onclick="quickAdd({{ $barang->barang_id }})">
                        <div class="relative aspect-square bg-orange-500 flex items-center justify-center">
                            <svg class="w-16 h-16 text-white opacity-20 group-hover:scale-110 transition-transform duration-300" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
                            </svg>
                        </div>
                        <div class="p-3 flex flex-col flex-grow">
                            <h3 class="font-semibold text-gray-700 text-sm mb-2 truncate">{{ $barang->nama_barang }}</h3>
                            <div class="flex items-center justify-between mt-auto">
                                <span class="text-gray-800 font-bold text-sm">Rp {{ number_format($barang->harga_barang,0,',','.') }}</span>
                                <div onclick="event.stopPropagation(); openQtyModal({{ $barang->barang_id }}, '{{ $barang->nama_barang }}', {{ $barang->harga_barang }})" class="bg-orange-500 hover:bg-orange-600 text-white w-8 h-8 flex items-center justify-center rounded-full shadow-md hover:shadow-lg transition-all duration-200 cursor-pointer">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"> <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/> </svg>
                                </div>
                            </div>
                        </div>
                    </button>
                </div>
                @empty
                {{-- [DISEMPURNAKAN] Pesan jika tidak ada menu sama sekali di database --}}
                <div class="w-full text-center py-10">
                    <p class="text-gray-500">Belum ada menu yang tersedia.</p>
                </div>
                @endforelse
                
                {{-- [DISEMPURNAKAN] Pesan jika pencarian tidak menemukan hasil --}}
                <div id="no-results" class="hidden w-full text-center py-10">
                    <p class="text-gray-500 font-semibold">Menu tidak ditemukan</p>
                    <p class="text-sm text-gray-400">Coba gunakan kata kunci lain.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Kolom Kanan: Keranjang --}}
    <div class="w-96 bg-white shadow-lg flex flex-col border-l border-gray-200">
        <div class="p-5 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-800">Keranjang</h3>
                @if(count(session('keranjang', [])) > 0)
                <span class="bg-orange-100 text-orange-600 px-3 py-1 rounded-full text-xs font-bold">
                    {{ count(session('keranjang', [])) }} item
                </span>
                @endif
            </div>
            <p class="text-gray-500 text-sm mt-1">Tinjau pesanan Anda</p>
        </div>

        <div class="flex-1 overflow-y-auto p-2">
            @php $total = 0; @endphp
            @if(count(session('keranjang', [])) > 0)
                @foreach(session('keranjang', []) as $item)
                    @php $total += $item['subtotal']; @endphp
                    <div class="p-4 mb-2 border-b border-gray-100">
                        <div class="flex justify-between items-start">
                            <h4 class="font-bold text-sm text-gray-800 flex-1 pr-2">{{ $item['nama'] }}</h4>
                            <form method="POST" action="{{ route('pos.transaksi.hapus_barang', $item['barang_id']) }}" class="ml-2">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-gray-400 hover:text-red-600 transition-colors" aria-label="Hapus item {{ $item['nama'] }}">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Rp {{ number_format($item['harga'],0,',','.') }}</p>
                        <div class="flex justify-between items-center mt-3">
                            <span class="text-sm text-gray-600">Qty: {{ $item['qty'] }}</span>
                            <span class="font-bold text-gray-800 text-sm">Rp {{ number_format($item['subtotal'],0,',','.') }}</span>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="flex flex-col items-center justify-center h-full text-gray-400 p-4 text-center">
                    <svg class="w-20 h-20 mb-4" fill="currentColor" viewBox="0 0 20 20"> <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/> </svg>
                    <p class="font-semibold">Keranjang masih kosong</p>
                    <p class="text-sm">Silakan pilih menu untuk memulai.</p>
                </div>
            @endif
        </div>

        <div class="border-t border-gray-200 p-4 bg-white">
            <div class="mb-4 space-y-2">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Subtotal:</span>
                    <span class="font-semibold text-lg text-gray-800">Rp {{ number_format($total,0,',','.') }}</span>
                </div>
                <div class="flex justify-between items-center text-lg font-bold text-orange-600">
                    <span>Total:</span>
                    <span>Rp {{ number_format($total,0,',','.') }}</span>
                </div>
            </div>

            <button id="scan-btn" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3.5 px-4 rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed disabled:shadow-md" {{ $total == 0 ? 'disabled' : '' }}>
                <div class="flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"> <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd" /> </svg>
                    <span>Mulai Scan & Bayar</span>
                </div>
            </button>

            <div id="siswa-info" class="hidden mt-3 p-3 bg-blue-50 border border-blue-200 rounded-lg text-sm"></div>
            
            <form id="bayar-form" method="POST" action="{{ route('pos.transaksi.bayar') }}" style="display:none;">
                @csrf
                <button type="submit" class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-3 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg mt-3">
                    Konfirmasi Pembayaran
                </button>
            </form>
        </div>
    </div>
</div>

{{-- Modal Kuantitas --}}
<div id="qty-modal" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm flex items-center justify-center z-50 transition-opacity duration-300">
    <div class="bg-white rounded-lg p-6 w-80 shadow-xl">
        <h3 class="text-lg font-bold mb-2" id="modal-item-name"></h3>
        <p class="text-sm text-gray-600 mb-4" id="modal-item-price"></p>
        
        <div class="flex items-center justify-center space-x-4 mb-6">
            <button type="button" onclick="updateModalQty(-1)" class="bg-gray-200 hover:bg-gray-300 text-gray-700 w-12 h-12 rounded-full text-2xl font-bold transition-colors">-</button>
            {{-- [DISEMPURNAKAN] Input hanya menerima angka dan event listener untuk tombol Enter --}}
            <input type="number" id="modal-qty" value="1" min="1" class="w-20 text-center text-2xl font-bold border-2 border-gray-300 rounded-lg py-2 focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none appearance-none [-moz-appearance:textfield]">
            <button type="button" onclick="updateModalQty(1)" class="bg-gray-200 hover:bg-gray-300 text-gray-700 w-12 h-12 rounded-full text-2xl font-bold transition-colors">+</button>
        </div>

        <form id="modal-form" method="POST" action="{{ route('pos.transaksi.tambah_barang') }}">
            @csrf
            <input type="hidden" name="barang_id" id="modal-barang-id">
            <input type="hidden" name="qty" id="modal-qty-submit" value="1">
            <div class="flex space-x-2">
                <button type="button" onclick="closeQtyModal()" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-3 rounded-lg transition-colors">Batal</button>
                <button type="submit" class="flex-1 bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 rounded-lg transition-colors">Tambah</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let polling = null;
    const totalBayar = {{ $total }};
    const barangData = @json($barangList->keyBy('barang_id'));
    
    const scanBtn = document.getElementById('scan-btn');
    const siswaInfo = document.getElementById('siswa-info');
    const bayarForm = document.getElementById('bayar-form');
    
    const qtyModal = document.getElementById('qty-modal');
    const modalItemName = document.getElementById('modal-item-name');
    const modalItemPrice = document.getElementById('modal-item-price');
    const modalBarangId = document.getElementById('modal-barang-id');
    const modalQtyInput = document.getElementById('modal-qty');
    const modalQtySubmit = document.getElementById('modal-qty-submit');
    const modalForm = document.getElementById('modal-form');

    const searchInput = document.getElementById('search-menu');
    const menuItems = document.querySelectorAll('.menu-item');
    const noResults = document.getElementById('no-results');

    // Fungsi untuk membuka modal kuantitas
    window.openQtyModal = function(barangId, namaBarang, harga) {
        modalItemName.textContent = namaBarang;
        modalItemPrice.textContent = 'Rp ' + harga.toLocaleString('id-ID');
        modalBarangId.value = barangId;
        modalQtyInput.value = 1;
        modalQtySubmit.value = 1;
        qtyModal.classList.remove('hidden');
        modalQtyInput.focus(); // Langsung fokus ke input
    }

    // Fungsi untuk menutup modal
    window.closeQtyModal = function() {
        qtyModal.classList.add('hidden');
    }

    // Fungsi untuk mengubah kuantitas di modal
    window.updateModalQty = function(delta) {
        let value = parseInt(modalQtyInput.value) + delta;
        if (isNaN(value) || value < 1) value = 1;
        modalQtyInput.value = value;
        modalQtySubmit.value = value;
    }
    
    // [DISEMPURNAKAN] Validasi input modal agar tidak bisa diisi nilai < 1
    modalQtyInput.addEventListener('input', () => {
        let value = parseInt(modalQtyInput.value);
        if (isNaN(value) || value < 1) {
            modalQtyInput.value = 1;
        }
        modalQtySubmit.value = modalQtyInput.value;
    });

    // [DISEMPURNAKAN] Submit modal dengan menekan tombol Enter
    modalQtyInput.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') {
            e.preventDefault();
            modalForm.submit();
        }
    });

    // Fungsi Quick Add (klik pada kartu)
    window.quickAdd = function(barangId) {
        const barang = barangData[barangId];
        if (barang) {
            // Langsung tambahkan 1 item ke keranjang tanpa membuka modal
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('pos.transaksi.tambah_barang') }}';
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const hiddenFields = `
                <input type="hidden" name="_token" value="${csrfToken}">
                <input type="hidden" name="barang_id" value="${barangId}">
                <input type="hidden" name="qty" value="1">
            `;
            form.innerHTML = hiddenFields;
            document.body.appendChild(form);
            form.submit();
        }
    }
    
    // Event listener untuk tombol Scan
    scanBtn.addEventListener('click', function() {
        if (totalBayar === 0) return;
        
        siswaInfo.innerHTML = '<div class="flex items-center"><svg class="animate-spin h-5 w-5 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Menunggu scan RFID siswa...</div>';
        siswaInfo.classList.remove('hidden');
        bayarForm.style.display = 'none';

        // [DISEMPURNAKAN] Menambahkan CSRF Token pada fetch request untuk keamanan
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        fetch('/api/transaksi/reset', { 
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        });
        polling = setInterval(fetchSiswaTransaksi, 2000);
    });

    // Fungsi untuk mengambil data siswa via polling
    function fetchSiswaTransaksi() {
        fetch('/api/transaksi/current')
            .then(res => res.json())
            .then(data => {
                if (data.siswa) {
                    clearInterval(polling);
                    let saldo = data.siswa.saldo ?? 0;
                    let html = `<div class="font-bold text-blue-700 mb-2">👤 ${data.siswa.nama ?? '-'} (${data.siswa.nis ?? '-'})</div>
                                <div class="mb-2">💰 Saldo: <span class="font-bold text-green-700">Rp ${saldo.toLocaleString('id-ID')}</span></div>`;
                    
                    if (saldo >= totalBayar) {
                        html += `<div class="text-green-600 font-bold mb-2">✅ Saldo cukup</div>`;
                        siswaInfo.innerHTML = html;
                        setTimeout(function() {
                            siswaInfo.innerHTML += '<div class="text-green-700 font-bold mt-2">⏳ Pembayaran diproses...</div>';
                            bayarForm.submit();
                        }, 1000);
                    } else {
                        html += `<div class="text-red-600 font-bold mb-2">❌ Saldo tidak cukup!</div>`;
                        siswaInfo.innerHTML = html;
                    }
                }
            })
            .catch(err => {
                console.error("Polling error:", err);
                clearInterval(polling);
            });
    }

    // [DISEMPURNAKAN] Fungsionalitas pencarian dengan pesan "tidak ditemukan"
    searchInput.addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        let visibleCount = 0;
        
        menuItems.forEach(item => {
            const itemName = item.querySelector('h3').textContent.toLowerCase();
            if (itemName.includes(searchTerm)) {
                item.style.display = 'flex';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        noResults.style.display = visibleCount === 0 ? 'block' : 'none';
    });

    // Menutup modal saat klik di luar area modal
    qtyModal.addEventListener('click', function(e) {
        if (e.target === this) closeQtyModal();
    });
});
</script>
@endsection