<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SaldoController;
use App\Http\Controllers\KantinController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardPaymentController;
use App\Http\Controllers\TopupController;
use App\Http\Controllers\PosTransaksiController;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Http\Controllers\TopupNotifyController;
use App\Http\Controllers\LaporanController;

Route::get('/', function () {
    return view('welcome');
});

// profile routes (auth for all logged in users)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
});

require __DIR__.'/auth.php';

// Routes that require authentication but role-specific access below
// ADMIN-only routes (admin dapat mengelola master data penuh + laporan)
Route::middleware(['auth', 'admin'])->group(function () {
    // Master Data (admin)
    Route::resource('siswa', SiswaController::class);
    Route::resource('user', UserController::class);
    Route::resource('kantin', KantinController::class);
    Route::resource('barang', BarangController::class);

    // Dashboard (admin view)
    Route::get('/dashboard', [DashboardPaymentController::class, 'index'])->name('dashboard.payment');

    // Laporan (admin)
    Route::prefix('laporan')->group(function () {
        Route::get('/income', [LaporanController::class, 'income'])->name('laporan.income');
        Route::get('/transaksi', [LaporanController::class, 'transaksi'])->name('laporan.transaksi');
        Route::get('/export/transaksi', [LaporanController::class, 'exportTransaksi'])->name('laporan.transaksi.export');
    });

    // Saldo view for admin
    Route::get('/pos/saldo', [SaldoController::class, 'index'])->name('saldo.index');
});

// PEMILIK_KANTIN-only routes (pemilik kantin mengelola POS, barang, dan melihat laporan/pos)
Route::middleware(['auth', 'pemilik_kantin'])->group(function () {
    // Barang -> pemilik kantin dapat mengelola barang kantin
    Route::resource('barang', BarangController::class);

    // POS / Transaksi
    Route::get('/pos/saldo', [SaldoController::class, 'index'])->name('saldo.index'); // juga tersedia untuk admin
    Route::get('/pos/kantin', [KantinController::class, 'index'])->name('kantin.index');
    Route::get('/pos/barang', [BarangController::class, 'index'])->name('barang.index');

    // Topup POS
    Route::get('/pos/topup', [TopupController::class, 'create'])->name('pos.topup');
    Route::post('/pos/topup', [TopupController::class, 'store'])->name('pos.topup.store');

    // POS transaksi (tambah/hapus/scan/bayar)
    Route::get('/pos/transaksi', [PosTransaksiController::class, 'index'])->name('pos.transaksi');
    Route::post('/pos/transaksi/tambah-barang', [PosTransaksiController::class, 'tambahBarang'])->name('pos.transaksi.tambah_barang');
    Route::delete('/pos/transaksi/hapus-barang/{barang_id}', [PosTransaksiController::class, 'hapusBarang'])->name('pos.transaksi.hapus_barang');
    Route::post('/pos/transaksi/scan-rfid', [PosTransaksiController::class, 'scanRfid'])->name('pos.transaksi.scan_rfid');
    Route::post('/pos/transaksi/bayar', [PosTransaksiController::class, 'bayar'])->name('pos.transaksi.bayar');

    // Topup notify endpoints (pemilik kantin bisa create/notify topup)
    Route::get('/pos/topup/new', [TopupNotifyController::class, 'create'])->name('pos.topup.create');
    Route::post('/pos/topup/notify', [TopupNotifyController::class, 'store'])->name('pos.topup.notify');

    // Dashboard for pemilik kantin (pakai same route name)
    Route::get('/dashboard', [DashboardPaymentController::class, 'index'])->name('dashboard.payment');

    // Jika ingin pemilik melihat laporan transaksi sederhana, bisa diaktifkan:
    Route::prefix('laporan')->group(function () {
        Route::get('/transaksi', [LaporanController::class, 'transaksi'])->name('laporan.transaksi');
    });
});

// Routes that should remain accessible to any authenticated user (non-role-specific)
Route::middleware(['auth'])->group(function () {
    // Search / helper / show pages that any authenticated user may need
    Route::get('/siswa/search-live', [SiswaController::class, 'searchLive'])->name('siswa.search.live');
    Route::get('/siswa/{siswa_id}/topup-histori', [SiswaController::class, 'topupHistoriView'])->name('siswa.topup.histori');
    Route::get('/topup/{siswa_id}', [TopupController::class, 'show'])->name('pos.topup.show');

    // WhatsApp features (auth required)
    Route::get('/whatsapp', [\App\Http\Controllers\WhatsappController::class, 'index'])->name('whatsapp.index');
    Route::post('/whatsapp/send', [\App\Http\Controllers\WhatsappController::class, 'send'])->name('whatsapp.send');
    Route::get('/whatsapp/report', [\App\Http\Controllers\WhatsappController::class, 'report'])->name('whatsapp.report');
});

// Public / webhook routes (no auth)
Route::get('/whatsapp/status', [\App\Http\Controllers\WhatsappController::class, 'status'])->name('whatsapp.status');
Route::get('/whatsapp/qr', [\App\Http\Controllers\WhatsappController::class, 'qr'])->name('whatsapp.qr');
Route::post('/webhook/fonnte', [\App\Http\Controllers\WhatsappController::class, 'webhook'])->name('whatsapp.webhook');
Route::get('/absensi/export/{type}', [\App\Http\Controllers\AbsensiController::class, 'export'])->name('absensi.export');
