@extends('layouts.app')
@section('content')
<div class="max-w-3xl mx-auto mt-8">
    <h2 class="text-xl font-bold mb-4">Transaksii Kantin</h2>

    <!-- Notifikasi Success/Error -->
    <?php
    if(session('success'))
        echo '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">'.session('success').'</div>';
    if(session('error'))
        echo '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">'.session('error').'</div>';
    ?>

    <!-- Pilih Barang (Tampilan Modern Cantik) -->
    <div class="mb-8">
        <h3 class="text-lg font-bold mb-3 text-gray-800">Daftar Menu Kantin</h3>
        
        <div class="bg-white rounded-lg border shadow-sm overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Menu</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-48">Jumlah</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($barangList as $barang)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $barang->nama_barang }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900 text-right font-medium">
                            Rp {{ number_format($barang->harga_barang,0,',','.') }}
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-center space-x-2">
                                <button type="button" 
                                    onclick="updateQty('qty-{{ $barang->barang_id }}', -1)"
                                    class="bg-gray-200 hover:bg-gray-300 text-gray-600 w-8 h-8 rounded-full flex items-center justify-center">
                                    -
                                </button>
                                <input type="number" 
                                    id="qty-{{ $barang->barang_id }}" 
                                    value="0" 
                                    min="0"
                                    onchange="validateQty(this)"
                                    class="w-16 text-center border rounded-md py-1">
                                <button type="button"
                                    onclick="updateQty('qty-{{ $barang->barang_id }}', 1)"
                                    class="bg-gray-200 hover:bg-gray-300 text-gray-600 w-8 h-8 rounded-full flex items-center justify-center">
                                    +
                                </button>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <form method="POST" action="{{ route('pos.transaksi.tambah_barang') }}" class="inline">
                                @csrf
                                <input type="hidden" name="barang_id" value="{{ $barang->barang_id }}">
                                <input type="hidden" name="qty" id="submit-qty-{{ $barang->barang_id }}">
                                <button type="button"
                                    onclick="addToCart(this, {{ $barang->barang_id }})"
                                    class="bg-orange-500 hover:bg-orange-600 text-white text-xs font-medium py-1 px-3 rounded-full">
                                    Tambah
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tabel Keranjang -->
    <div class="mb-8">
        <h3 class="text-lg font-bold mb-2">Keranjang Belanja</h3>
        <table class="min-w-full bg-white border rounded shadow">
            <thead>
                <tr class="bg-orange-100">
                    <th class="px-4 py-2 border text-center">Barang</th>
                    <th class="px-4 py-2 border text-center">Qty</th>
                    <th class="px-4 py-2 border text-center">Harga</th>
                    <th class="px-4 py-2 border text-center">Subtotal</th>
                    <th class="px-4 py-2 border text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach(session('keranjang', []) as $item)
                @php $total += $item['subtotal']; @endphp
                <tr>
                    <td class="px-4 py-2 border text-center">{{ $item['nama'] }}</td>
                    <td class="px-4 py-2 border text-center">{{ $item['qty'] }}</td>
                    <td class="px-4 py-2 border text-center">Rp. {{ number_format($item['harga'],0,'','.') }}</td>
                    <td class="px-4 py-2 border text-center">Rp. {{ number_format($item['subtotal'],0,'','.') }}</td>
                    <td class="px-4 py-2 border text-center">
                        <form method="POST" action="{{ route('pos.transaksi.hapus_barang', $item['barang_id']) }}">
                            @csrf @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="text-right mt-4 text-lg font-bold">
            Total: Rp. {{ number_format($total,0,'','.') }}
        </div>
    </div>

    <!-- Scan RFID Siswa -->
    <div class="mt-6">
        <button id="scan-btn" class="bg-blue-500 text-white px-6 py-2 rounded font-bold w-full mb-2">Mulai Scan Bayar</button>
        <div id="siswa-info" class="hidden mt-4 p-4 bg-blue-50 border border-blue-200 rounded"></div>
        <form id="bayar-form" method="POST" action="{{ route('pos.transaksi.bayar') }}" style="display:none;">
            @csrf
            <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white px-6 py-2 rounded font-bold w-full">Bayar</button>
        </form>
    </div>

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
</div>
@endsection