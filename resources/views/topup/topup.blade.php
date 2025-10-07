<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Up Saldo Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .container { max-width: 900px; }
        .card { border: none; border-radius: 0.75rem; }
        .table-responsive { max-height: 350px; }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white text-center">
            <h4 class="mb-0">✨ Form Top Up Saldo Siswa</h4>
        </div>
        <div class="card-body p-4">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Berhasil!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Gagal!</strong> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <a href="{{ route('dashboard.payment') }}" class="btn btn-secondary mb-3">
                &larr; Kembali ke Dashboard Payment
            </a>

            <form action="{{ route('pos.topup.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="siswa_id" class="form-label fw-bold">Pilih Siswa</label>
                    <select name="siswa_id" id="siswa_id" class="form-select" required>
                        <option value="">-- Pilih Siswa --</option>
                        @foreach(\App\Models\Siswa::orderBy('nama')->get() as $siswa)
                            <option value="{{ $siswa->id }}">
                                {{ $siswa->nama }} (NIS: {{ $siswa->nis }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="nominal" class="form-label fw-bold">Nominal Top Up</label>
                    <input type="number" name="nominal" id="nominal" class="form-control" min="1000" required placeholder="Masukkan nominal top up">
                </div>
                <button type="submit" class="btn btn-success">Top Up</button>
            </form>

            <!-- Tabel Histori Top Up Semua Siswa -->
            <h5 class="fw-bold mb-2 mt-4">Histori Top Up Seluruh Siswa</h5>
            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Nominal</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($historiAll as $topup)
                            <tr>
                                <td>{{ $topup->siswa->nama ?? '-' }}</td>
                                <td>{{ $topup->siswa->kelas->nama ?? '-' }}</td>
                                <td>Rp{{ number_format($topup->nominal,0,',','.') }}</td>
                                <td>{{ \Carbon\Carbon::parse($topup->waktu ?? $topup->created_at)->format('d-m-Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="text-center mt-3 text-muted">
        <small>Sistem Pembayaran Sekolah &copy; {{ date('Y') }}</small>
    </div>
</div>

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
</body>
</html>