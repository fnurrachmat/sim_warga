<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WargaController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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


require __DIR__.'/auth.php';
