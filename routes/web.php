<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AbsensiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RombelSiswaController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SaldoController;
use App\Http\Controllers\KantinController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardPaymentController;
use App\Http\Controllers\TopupController;
use App\Http\Controllers\PosTransaksiController;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Http\Controllers\LaporanTransaksiController;
use App\Http\Controllers\TopupNotifyController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('guru', GuruController::class);
    Route::resource('siswa', SiswaController::class);
    Route::resource('rombel_siswa', RombelSiswaController::class);
    Route::resource('absensi', AbsensiController::class);
    Route::resource('kelas', KelasController::class);
    Route::resource('tahun_ajaran', TahunAjaranController::class);
    Route::resource('user', UserController::class);
    Route::resource('kantin', KantinController::class);
    Route::post('/rombel_siswa/mass_store', [RombelSiswaController::class, 'mass_store'])->name('rombel_siswa.mass_store');
    Route::post('/rombel_siswa/ganti-kelas-massal', [RombelSiswaController::class, 'gantiKelasMassal'])->name('rombel_siswa.ganti_kelas_massal');
});

require __DIR__.'/auth.php';

// Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');
Route::middleware(['auth'])->group(function () {
    // Dashboard Absensi
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard.absensi');

    // Dashboard Payment
    Route::get('/dashboard-payment', [DashboardPaymentController::class, 'index'])->name('dashboard.payment');
});
Route::get('/whatsapp', [\App\Http\Controllers\WhatsappController::class, 'index'])->name('whatsapp.index')->middleware('auth');
Route::post('/whatsapp/send', [\App\Http\Controllers\WhatsappController::class, 'send'])->name('whatsapp.send')->middleware('auth');
Route::get('/absensi/export/{type}', [\App\Http\Controllers\AbsensiController::class, 'export'])->name('absensi.export');
Route::get('/whatsapp/status', [\App\Http\Controllers\WhatsappController::class, 'status'])->name('whatsapp.status');
Route::get('/whatsapp/qr', [\App\Http\Controllers\WhatsappController::class, 'qr'])->name('whatsapp.qr');
Route::post('/webhook/fonnte', [\App\Http\Controllers\WhatsappController::class, 'webhook'])->name('whatsapp.webhook');
Route::get('/whatsapp/report', [\App\Http\Controllers\WhatsappController::class, 'report'])->name('whatsapp.report')->middleware('auth');
Route::get('/profile', [ProfileController::class, 'index'])->middleware('auth')->name('profile.index');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->middleware('auth')->name('profile.edit');
use App\Http\Controllers\SetPasswordController;
// Set Password Guru (tanpa middleware auth, agar guru bisa akses langsung)
Route::get('/set-password', [SetPasswordController::class, 'create'])->name('set-password.create');
Route::post('/set-password', [SetPasswordController::class, 'store'])->name('set-password.store');

#testing export absensi
Route::get('/absensi/export/{type}', [App\Http\Controllers\RekapAbsensiController::class, 'export'])->name('absensi.export');
#testing export rombel siswa
Route::get('/rombel_siswa/export/pdf', [App\Http\Controllers\RombelSiswaController::class, 'exportPdf'])->name('rombel_siswa.export.pdf');

// Dummy routes for POS system (to be replaced with actual controllers and views)
Route::middleware(['auth'])->group(function () {
    Route::get('/pos/transaksi', function() {
        return view('pos.transaksi');
    })->name('pos.transaksi');
    Route::get('/pos/laporan', function() {
        return view('pos.laporan');
    })->name('pos.laporan');
    Route::get('/pos/masterdata', function() {
        return view('pos.masterdata');
    })->name('pos.masterdata');
});

// Kantin Cashless
Route::get('/pos/saldo', [SaldoController::class, 'index'])->name('saldo.index');
Route::get('/pos/kantin', [KantinController::class, 'index'])->name('kantin.index');
Route::get('/pos/barang', [BarangController::class, 'index'])->name('barang.index');

Route::middleware(['auth'])->group(function () {
    Route::resource('barang', BarangController::class);
    Route::get('/pos/topup', [TopupController::class, 'create'])->name('pos.topup');
    Route::post('/pos/topup', [TopupController::class, 'store'])->name('pos.topup.store');
});

Route::get('/siswa/search-live', [SiswaController::class, 'searchLive'])->name('siswa.search.live');
Route::get('/siswa/{siswa_id}/topup-histori', [SiswaController::class, 'topupHistoriView'])->name('siswa.topup.histori');
Route::get('/topup/{siswa_id}', [TopupController::class, 'show'])->name('pos.topup.show');

// Route POS Transaksi

Route::get('/pos/transaksi', [PosTransaksiController::class, 'index'])->name('pos.transaksi');
Route::post('/pos/transaksi/tambah-barang', [PosTransaksiController::class, 'tambahBarang'])->name('pos.transaksi.tambah_barang');
Route::delete('/pos/transaksi/hapus-barang/{barang_id}', [PosTransaksiController::class, 'hapusBarang'])->name('pos.transaksi.hapus_barang');
Route::post('/pos/transaksi/scan-rfid', [PosTransaksiController::class, 'scanRfid'])->name('pos.transaksi.scan_rfid');
Route::post('/pos/transaksi/bayar', [PosTransaksiController::class, 'bayar'])->name('pos.transaksi.bayar');

// POS Routes
Route::prefix('pos')->middleware(['auth'])->group(function () {
    // Laporan Transaksi Route
    Route::get('/laporan', [LaporanTransaksiController::class, 'index'])->name('pos.laporan');
});

// Pastikan berada di group yang menggunakan middleware auth jika diperlukan
Route::middleware(['auth'])->group(function () {
    // halaman form topup (opsional)
    Route::get('/pos/topup/new', [TopupNotifyController::class, 'create'])->name('pos.topup.create');

    // aksi topup + notifikasi
    Route::post('/pos/topup/notify', [TopupNotifyController::class, 'store'])->name('pos.topup.notify');
});