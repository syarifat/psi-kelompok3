@extends('layouts.app')
@section('content')
<div class="flex h-screen bg-gray-100">
    <!-- Left Column - Product List -->
    <div class="flex-1 p-6 overflow-auto mr-[400px]"> <!-- Added margin-right to accommodate fixed cart -->
        <h2 class="text-xl font-bold mb-4">Menu Kantin</h2>
        
        <!-- Search Bar -->
        <div class="mb-4">
            <input type="text" placeholder="Cari menu..." 
                class="w-full px-4 py-2 rounded-lg border focus:outline-none focus:ring-2 focus:ring-orange-400">
        </div>

        <!-- Products List -->
        <div class="space-y-2">
            @foreach($barangList as $barang)
            <div class="bg-white p-4 rounded-lg shadow-sm hover:shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="font-medium text-gray-800">{{ $barang->nama_barang }}</div>
                        <div class="text-orange-600 font-bold">Rp {{ number_format($barang->harga_barang,0,',','.') }}</div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button type="button" onclick="updateQty('qty-{{ $barang->barang_id }}', -1)"
                            class="bg-gray-100 hover:bg-gray-200 w-8 h-8 rounded-full flex items-center justify-center text-gray-600">-</button>
                        <input type="number" id="qty-{{ $barang->barang_id }}" value="0" min="0"
                            class="w-14 text-center border rounded-md py-1"
                            onchange="validateQty(this)">
                        <button type="button" onclick="updateQty('qty-{{ $barang->barang_id }}', 1)"
                            class="bg-gray-100 hover:bg-gray-200 w-8 h-8 rounded-full flex items-center justify-center text-gray-600">+</button>
                        <form method="POST" action="{{ route('pos.transaksi.tambah_barang') }}" class="inline">
                            @csrf
                            <input type="hidden" name="barang_id" value="{{ $barang->barang_id }}">
                            <input type="hidden" name="qty" id="submit-qty-{{ $barang->barang_id }}">
                            <button type="button" onclick="addToCart(this, {{ $barang->barang_id }})"
                                class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg">
                                Add
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Right Column - Cart (Fixed) -->
    <div class="fixed right-0 top-0 bottom-0 w-[400px] bg-white border-l shadow-lg flex flex-col">
        <div class="p-6 flex flex-col h-full">
            <h2 class="text-xl font-bold mb-4">Keranjang</h2>
            
            <!-- Cart Items -->
            <div class="flex-1 overflow-auto space-y-4">
                @foreach(session('keranjang', []) as $item)
                <div class="flex items-center justify-between py-2 border-b">
                    <div class="flex-1">
                        <div class="flex justify-between">
                            <span class="font-medium">{{ $item['nama'] }}</span>
                            <span class="font-bold">Rp {{ number_format($item['subtotal'],0,'','.') }}</span>
                        </div>
                        <div class="text-sm text-gray-500">{{ $item['qty'] }}x @ Rp {{ number_format($item['harga'],0,'','.') }}</div>
                    </div>
                    <form method="POST" action="{{ route('pos.transaksi.hapus_barang', $item['barang_id']) }}" class="ml-4">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-600">×</button>
                    </form>
                </div>
                @endforeach
            </div>

            <!-- Total & Checkout (Sticky Bottom) -->
            <div class="border-t pt-4">
                <div class="flex justify-between mb-4 text-lg">
                    <span>Total</span>
                    <span class="font-bold">Rp {{ number_format($total,0,'','.') }}</span>
                </div>
                
                <button id="scan-btn" 
                    class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 rounded-lg mb-2">
                    Scan RFID untuk Bayar
                </button>
                
                <div id="siswa-info" class="hidden mt-4 p-4 bg-orange-50 rounded-lg"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let polling = null;
document.getElementById('scan-btn').onclick = function() {
    document.getElementById('siswa-info').innerHTML = 'Menunggu scan RFID siswa...';
    document.getElementById('siswa-info').classList.remove('hidden');
    document.getElementById('bayar-form').style.display = 'none';
    fetch('/api/transaksi/reset', { method: 'POST' });
    polling = setInterval(fetchSiswaTransaksi, 2000);
};

function fetchSiswaTransaksi() {
    fetch('/api/transaksi/current')
        .then(res => res.json())
        .then(data => {
            if (data.siswa) {
                let total = {{ $total }};
                let saldo = data.siswa.saldo ?? 0;
                let html = `<div class="font-bold text-blue-700 mb-2">Siswa: ${data.siswa.nama ?? '-'} (${data.siswa.nis ?? '-'})</div>
                    <div class="mb-2">Saldo: <span class="font-bold text-green-700">Rp. ${saldo.toLocaleString()}</span></div>`;
                if (saldo >= total) {
                    html += `<div class="text-green-600 font-bold mb-2">Saldo cukup</div>`;
                    document.getElementById('bayar-form').style.display = 'none';
                    clearInterval(polling);
                    // Otomatis submit pembayaran
                    setTimeout(function() {
                        document.getElementById('siswa-info').innerHTML += '<div class="text-green-700 font-bold">Pembayaran diproses...</div>';
                        document.getElementById('bayar-form').submit();
                    }, 1000);
                } else {
                    html += `<div class="text-red-600 font-bold mb-2">Saldo siswa tidak cukup!</div>`;
                    document.getElementById('bayar-form').style.display = 'none';
                    clearInterval(polling);
                }
                document.getElementById('siswa-info').innerHTML = html;
            }
        });
}

function validateQty(input) {
    let value = parseInt(input.value) || 0;
    if (value < 0) value = 0;
    input.value = value;
}

function updateQty(inputId, delta) {
    const input = document.getElementById(inputId);
    let value = parseInt(input.value) + delta;
    if (value < 0) value = 0;
    input.value = value;
}

function addToCart(button, barangId) {
    const qty = parseInt(document.getElementById(`qty-${barangId}`).value);
    if (qty > 0) {
        // Set the quantity to hidden input
        document.getElementById(`submit-qty-${barangId}`).value = qty;
        // Get the form and submit it
        button.closest('form').submit();
        // Reset quantity to 0
        document.getElementById(`qty-${barangId}`).value = 0;
    }
}
</script>
@endsection