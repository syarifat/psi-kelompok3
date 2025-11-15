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

// all users
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    // Dashboard
    Route::get('/dashboard', [DashboardPaymentController::class, 'index'])->name('dashboard.payment');
    
    Route::get('/siswa/search-live', [SiswaController::class, 'searchLive'])->name('siswa.search.live');
    
    Route::get('/topup/{siswa_id}', [TopupController::class, 'show'])->name('pos.topup.show');
    // Kelola data barang
    Route::resource('barang', BarangController::class);

    // Laporan (admin)
    Route::prefix('laporan')->group(function () {
        Route::get('/income', [LaporanController::class, 'income'])->name('laporan.income');
        Route::get('/transaksi', [LaporanController::class, 'transaksi'])->name('laporan.transaksi');
        Route::get('/export/transaksi', [LaporanController::class, 'exportTransaksi'])->name('laporan.transaksi.export');
        Route::get('/transaksi', [LaporanController::class, 'transaksi'])->name('laporan.transaksi');
    });

});

require __DIR__.'/auth.php';

// admin users
Route::middleware(['auth', 'admin'])->group(function () {
    // Master Data (admin)
    Route::resource('siswa', SiswaController::class);
    Route::resource('user', UserController::class);
    Route::resource('kantin', KantinController::class);
    
    // Lihat saldo
    Route::get('/pos/saldo', [SaldoController::class, 'index'])->name('saldo.index');
    Route::get('/siswa/{siswa_id}/topup-histori', [SiswaController::class, 'topupHistoriView'])->name('siswa.topup.histori');
    // Topup POS
    Route::get('/pos/topup', [TopupController::class, 'create'])->name('pos.topup');
    Route::post('/pos/topup', [TopupController::class, 'store'])->name('pos.topup.store');
    // Topup notify endpoints (pemilik kantin bisa create/notify topup)
    Route::get('/pos/topup/new', [TopupNotifyController::class, 'create'])->name('pos.topup.create');
    Route::post('/pos/topup/notify', [TopupNotifyController::class, 'store'])->name('pos.topup.notify');

    Route::get('/siswa/{siswa_id}/transaksi-history', [SiswaController::class, 'transaksiHistoriView'])
        ->name('siswa.transaksi.history');
});

// pemilik_kantin users
Route::middleware(['auth', 'pemilik_kantin'])->group(function () {

    // POS / Transaksi
    Route::get('/pos/kantin', [KantinController::class, 'index'])->name('kantin.index');
    Route::get('/pos/barang', [BarangController::class, 'index'])->name('barang.index');

    // POS transaksi (tambah/hapus/scan/bayar)
    Route::get('/pos/transaksi', [PosTransaksiController::class, 'index'])->name('pos.transaksi');
    Route::post('/pos/transaksi/tambah-barang', [PosTransaksiController::class, 'tambahBarang'])->name('pos.transaksi.tambah_barang');
    Route::delete('/pos/transaksi/hapus-barang/{barang_id}', [PosTransaksiController::class, 'hapusBarang'])->name('pos.transaksi.hapus_barang');
    Route::post('/pos/transaksi/scan-rfid', [PosTransaksiController::class, 'scanRfid'])->name('pos.transaksi.scan_rfid');
    Route::post('/pos/transaksi/bayar', [PosTransaksiController::class, 'bayar'])->name('pos.transaksi.bayar');
});