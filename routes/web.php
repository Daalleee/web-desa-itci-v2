<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\KartuKeluargaController;
use App\Http\Controllers\LetterController;
use App\Http\Controllers\SocialAssistanceController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BackupController;

// Rute Publik & Autentikasi
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute Publik Pengecekan Surat Otomatis via QR
Route::get('/verify/surat/{id}', [LetterController::class, 'verify'])->name('surat.verify');

// Rute Dashboard (Terproteksi Autentikasi)
Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    
    // Dashboard Utama
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // 1. Modul Data Warga (Operator & Admin)
    Route::middleware(['role:Operator Desa,Kepala Desa,Ketua RT'])->group(function() {
        Route::resource('warga', WargaController::class);
        
        // 2. Modul Kartu Keluarga
        Route::resource('kartu-keluarga', KartuKeluargaController::class);
        
        // 5. Modul Surat Otomatis
        Route::resource('surat', LetterController::class)->except(['edit', 'update']);
        
        // 6. Modul Bantuan Sosial
        Route::middleware(['role:Operator Desa,Kepala Desa'])->group(function() {
            Route::resource('bantuan', SocialAssistanceController::class);
            Route::post('bantuan/{bantuan}/tambah-penerima', [SocialAssistanceController::class, 'addRecipient'])->name('bantuan.addRecipient');
            Route::delete('bantuan/{bantuan}/hapus-penerima/{wargaId}', [SocialAssistanceController::class, 'removeRecipient'])->name('bantuan.removeRecipient');
        });
        
        // 8. Modul Arsip Dokumen
        Route::middleware(['role:Operator Desa'])->group(function() {
            Route::get('dokumen', [DocumentController::class, 'index'])->name('dokumen.index');
            Route::post('dokumen', [DocumentController::class, 'store'])->name('dokumen.store');
            Route::delete('dokumen/{id}', [DocumentController::class, 'destroy'])->name('dokumen.destroy');
        });
        
        // 10. Modul Laporan & 3. Import & 4. Export
        Route::get('laporan', [ReportController::class, 'index'])->name('laporan.index');
        Route::get('laporan/ekspor/csv', [ReportController::class, 'exportWarga'])->name('laporan.export');
        Route::get('laporan/template/csv', [ReportController::class, 'downloadTemplate'])->name('laporan.template');
        Route::post('laporan/impor/preview', [ReportController::class, 'previewImport'])->name('laporan.preview');
        Route::post('laporan/impor/proses', [ReportController::class, 'importWarga'])->name('laporan.import');
    });

    // 11. Modul User Management (Khusus Super Admin)
    Route::middleware(['role:Super Admin'])->group(function() {
        Route::resource('users', UserController::class);
        
        // 12. Modul Backup (Khusus Super Admin)
        Route::get('backup', [BackupController::class, 'index'])->name('backup.index');
        Route::get('backup/download', [BackupController::class, 'download'])->name('backup.download');
    });
});