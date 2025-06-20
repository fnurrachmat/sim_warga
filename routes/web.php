<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\SuratPengantarController;
use App\Http\Controllers\KeuanganController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('login');
});


Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//warga
Route::resource('warga', WargaController::class);
//pdf warga
Route::get('warga/export/pdf', [WargaController::class, 'exportPdf'])->name('warga.export.pdf');
//excell warga
Route::get('warga/export/excel', [WargaController::class, 'exportExcel'])->name('warga.export.excel');



// Daftar KK
Route::get('/keluarga', [WargaController::class, 'keluargaIndex'])->name('keluarga.index');

// Detail per KK
Route::get('/keluarga/{no_kk}', [WargaController::class, 'keluargaDetail'])->name('keluarga.detail');

//PDF Keluarga
Route::get('/keluarga/{no_kk}/pdf', [WargaController::class, 'keluargaExportPdf'])->name('keluarga.export.pdf');


// Surat Pengantar
Route::get('/surat', [SuratPengantarController::class, 'index'])->name('surat.index');
Route::get('/surat/create', [SuratPengantarController::class, 'create'])->name('surat.create');
Route::post('/surat', [SuratPengantarController::class, 'store'])->name('surat.store');
Route::get('/surat/{id}/cetak', [SuratPengantarController::class, 'cetakPdf'])->name('surat.cetak');

// Keuangan Kas RT
Route::resource('keuangan', KeuanganController::class);
Route::get('/keuangan/export/pdf', [KeuanganController::class, 'exportPdf'])->name('keuangan.export.pdf');

require __DIR__.'/auth.php';
