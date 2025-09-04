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

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\DashboardController;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

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
    Route::post('/rombel_siswa/mass_store', [RombelSiswaController::class, 'mass_store'])->name('rombel_siswa.mass_store');
    Route::post('/rombel_siswa/ganti-kelas-massal', [RombelSiswaController::class, 'gantiKelasMassal'])->name('rombel_siswa.ganti_kelas_massal');
});

require __DIR__.'/auth.php';

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');
Route::get('/whatsapp', [\App\Http\Controllers\WhatsappController::class, 'index'])->name('whatsapp.index')->middleware('auth');
Route::post('/whatsapp/send', [\App\Http\Controllers\WhatsappController::class, 'send'])->name('whatsapp.send')->middleware('auth');
Route::get('/absensi/export/{type}', [\App\Http\Controllers\AbsensiController::class, 'export'])->name('absensi.export');
Route::get('/whatsapp/status', [\App\Http\Controllers\WhatsappController::class, 'status'])->name('whatsapp.status');
Route::get('/whatsapp/qr', [\App\Http\Controllers\WhatsappController::class, 'qr'])->name('whatsapp.qr');
Route::post('/webhook/fonnte', [\App\Http\Controllers\WhatsappController::class, 'webhook'])->name('whatsapp.webhook');
Route::get('/whatsapp/report', [\App\Http\Controllers\WhatsappController::class, 'report'])->name('whatsapp.report')->middleware('auth');
Route::get('/profile', [ProfileController::class, 'index'])->middleware('auth')->name('profile.index');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->middleware('auth')->name('profile.edit');