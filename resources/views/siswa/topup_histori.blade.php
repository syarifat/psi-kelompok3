<!-- filepath: d:\KULIAH\proyek sistem informasi\psi-kelompok3\resources\views\siswa\topup_histori.blade.php -->
@extends('layouts.app')
@section('content')
<div class="container mt-4 mb-5">
    <div class="card shadow-sm border overflow-hidden" style="border-radius: 12px;">
        <!-- Header minimalis -->
        <div class="card-header bg-white border-bottom position-relative" style="padding: 1.5rem;">
            <div class="d-flex align-items-center">
                <div class="icon-wrapper me-3" style="width: 45px; height: 45px; background: #f8f9fa; border: 2px solid #dee2e6; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-history text-dark" style="font-size: 1.3rem;"></i>
                </div>
                <div>
                    <h4 class="mb-1 fw-bold text-dark">Histori Topup</h4>
                    <p class="mb-0 text-muted small">Riwayat pengisian saldo</p>
                </div>
            </div>
        </div>

        <div class="card-body p-4 bg-white">
            <!-- Info Siswa dengan design card putih -->
            <div class="info-card mb-4 p-3 border" style="border-radius: 10px; background: #fafafa;">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <div class="icon-box me-3" style="width: 38px; height: 38px; background: #e9ecef; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-user text-dark"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block mb-1">Nama Siswa</small>
                                <span class="fw-bold text-dark">{{ $siswa->nama }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <div class="icon-box me-3" style="width: 38px; height: 38px; background: #e9ecef; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-id-card text-dark"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block mb-1">Nomor Induk</small>
                                <span class="fw-bold text-dark">{{ $siswa->nis }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table dengan styling minimalis -->
            <div class="table-responsive">
                <table class="table table-hover align-middle" style="border-collapse: separate; border-spacing: 0;">
                    <thead>
                        <tr style="background: #f8f9fa;">
                            <th class="text-dark text-center py-3 border-bottom border-top" style="border-top-left-radius: 8px;">
                                <i class="fas fa-money-bill-wave me-2"></i>Nominal
                            </th>
                            <th class="text-dark text-center py-3 border-bottom border-top" style="border-top-right-radius: 8px;">
                                <i class="fas fa-calendar-alt me-2"></i>Tanggal & Waktu
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topups as $index => $topup)
                        <tr class="topup-row" style="transition: all 0.2s ease;">
                            <td class="text-center border-bottom py-3" style="background: #ffffff;">
                                <div class="nominal-badge d-inline-flex align-items-center px-4 py-2" style="background: #f8f9fa; border: 2px solid #dee2e6; border-radius: 8px;">
                                    <i class="fas fa-coins text-dark me-2"></i>
                                    <span class="text-dark fw-bold fs-5">Rp{{ number_format($topup->nominal, 0, ',', '.') }}</span>
                                </div>
                            </td>
                            <td class="text-center border-bottom py-3" style="background: #ffffff;">
                                <div class="date-badge d-inline-flex align-items-center px-3 py-2" style="background: #f8f9fa; border: 2px solid #dee2e6; border-radius: 8px;">
                                    <i class="fas fa-clock text-dark me-2"></i>
                                    <span class="text-dark fw-semibold">{{ \Carbon\Carbon::parse($topup->waktu ?? $topup->created_at)->format('d M Y, H:i') }}</span>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="text-center py-5 border-0">
                                <div class="empty-state">
                                    <i class="fas fa-inbox text-muted mb-3" style="font-size: 4rem; opacity: 0.2;"></i>
                                    <p class="text-muted mb-0 fs-5">Belum ada histori topup</p>
                                    <small class="text-muted">Riwayat topup akan muncul di sini</small>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Button kembali dengan styling minimalis -->
            <div class="mt-4">
                <a href="{{ url()->previous() }}" class="btn btn-lg px-4 py-2 border-dark" style="background: #ffffff; color: #212529; border: 2px solid #212529; border-radius: 8px; transition: all 0.3s ease;">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .topup-row:hover {
        background: #f8f9fa !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    .topup-row:hover td {
        background: #f8f9fa !important;
    }

    .btn:hover {
        background: #212529 !important;
        color: #ffffff !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .nominal-badge, .date-badge {
        transition: all 0.3s ease;
    }

    .topup-row:hover .nominal-badge,
    .topup-row:hover .date-badge {
        border-color: #6c757d;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .card {
        animation: fadeIn 0.5s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<!-- Tambahkan Font Awesome jika belum ada -->
@if(!isset($fontAwesomeLoaded))
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endif
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        var siswa_id = "{{ $siswa->id }}";
        
        // Fetch histori topup saat halaman dimuat
        $.get("/siswa/" + siswa_id + "/topup-histori", function(data) {
            // ...
        });
    });
</script>
@endsection