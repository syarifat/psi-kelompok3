@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-3xl p-4">
    <div class="bg-white rounded shadow">
        <div class="border-b px-6 py-4 bg-orange-500 rounded-t">
            <h4 class="text-lg font-bold text-white text-center">✨ Form Top Up Saldo Siswa</h4>
        </div>
        <div class="px-6 py-6">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    <strong>Berhasil!</strong> {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <strong>Gagal!</strong> {{ session('error') }}
                </div>
            @endif

            <a href="{{ route('dashboard.payment') }}" class="inline-block mb-4 bg-orange-100 hover:bg-orange-200 text-orange-700 px-4 py-2 rounded transition">
                &larr; Kembali ke Dashboard Payment
            </a>

            <form action="{{ route('pos.topup.store') }}" method="POST" class="mb-6">
                @csrf
                <div class="mb-4">
                    <label for="siswa_id" class="block font-semibold mb-1 text-gray-700">Pilih Siswa</label>
                    <select name="siswa_id" id="siswa_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400" required>
                        <option value="">-- Pilih Siswa --</option>
                        @foreach(\App\Models\Siswa::orderBy('nama')->get() as $siswa)
                            <option value="{{ $siswa->id }}">
                                {{ $siswa->nama }} (NIS: {{ $siswa->nis }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="nominal" class="block font-semibold mb-1 text-gray-700">Nominal Top Up</label>
                    <input type="number" name="nominal" id="nominal" min="1000" required placeholder="Masukkan nominal top up"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400">
                </div>
                <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded transition">Top Up</button>
            </form>

            <h5 class="font-bold mb-2 mt-6 text-gray-700">Histori Top Up Seluruh Siswa</h5>
            <div class="overflow-x-auto rounded">
                <table class="min-w-full bg-white border border-gray-200 text-sm">
                    <thead class="bg-orange-100">
                        <tr>
                            <th class="px-4 py-2 border-b text-left text-orange-700">Nama</th>
                            <th class="px-4 py-2 border-b text-left text-orange-700">Kelas</th>
                            <th class="px-4 py-2 border-b text-left text-orange-700">Nominal</th>
                            <th class="px-4 py-2 border-b text-left text-orange-700">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($historiAll as $topup)
                            <tr class="hover:bg-orange-50">
                                <td class="px-4 py-2 border-b">{{ $topup->siswa->nama ?? '-' }}</td>
                                <td class="px-4 py-2 border-b">{{ $topup->siswa->kelas->nama ?? '-' }}</td>
                                <td class="px-4 py-2 border-b">Rp{{ number_format($topup->nominal,0,',','.') }}</td>
                                <td class="px-4 py-2 border-b">{{ \Carbon\Carbon::parse($topup->waktu ?? $topup->created_at)->format('d-m-Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(function() {
    // Live search siswa
    $('#search_siswa').on('input', function() {
        let keyword = $(this).val();
        if (keyword.length < 2) {
            $('#table_siswa tbody').html('');
            return;
        }
        $.get("{{ route('siswa.search.live') }}", { q: keyword }, function(data) {
            let rows = '';
            if (data.length === 0) {
                rows = '<tr><td colspan="5" class="text-center text-muted">Tidak ditemukan</td></tr>';
            } else {
                data.forEach(function(siswa) {
                    rows += `<tr>
                        <td>${siswa.nama}</td>
                        <td>${siswa.kelas_nama ?? '-'}</td>
                        <td>${siswa.absen ?? '-'}</td>
                        <td>
                            <form action="{{ route('pos.topup.store') }}" method="POST" class="d-flex gap-2">
                                @csrf
                                <input type="hidden" name="siswa_id" value="${siswa.id}">
                                <input type="number" name="nominal" class="form-control form-control-sm" placeholder="Nominal" min="1000" required style="width:100px;">
                                <button type="submit" class="btn btn-success btn-sm">Top Up</button>
                            </form>
                        </td>
                        <td>
                            <button type="button" class="btn btn-info btn-sm" onclick="showHistori(${siswa.id}, '${siswa.nama}')">Histori</button>
                        </td>
                    </tr>`;
                });
            }
            $('#table_siswa tbody').html(rows);
        });
    });
});

// Modal histori siswa (simple alert, bisa diganti modal Bootstrap)
function showHistori(siswa_id, nama) {
    $.get("/siswa/" + siswa_id + "/topup-histori", function(data) {
        let msg = `Histori Top Up ${nama}:\n\n`;
        if (data.length === 0) {
            msg += 'Belum ada histori top up.';
        } else {
            data.forEach(function(item) {
                msg += `Rp${item.nominal.toLocaleString()} - ${item.created_at}\n`;
            });
        }
        alert(msg);
    });
}
</script>
@endpush