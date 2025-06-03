<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DosenController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    // Arahkan berdasarkan role
    if (Auth::user()->isDosen()) {
        // Redirect ke dashboard dosen (akan dibuat nanti)
        return redirect()->route('dosen.dashboard');
    } elseif (Auth::user()->isMahasiswa()) {
        // Redirect ke halaman upload dokumen untuk mahasiswa
        return redirect()->route('documents.index');
    }
    // Default fallback jika role tidak dikenali
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes untuk Mahasiswa (Upload Dokumen)
    Route::middleware('role:mahasiswa')->group(function () { // Middleware role akan kita buat
        Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
        Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
        Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');
    });

    // Routes untuk Dosen
    Route::middleware('role:dosen')->prefix('dosen')->name('dosen.')->group(function () {
        Route::get('/dashboard', [DosenController::class, 'dashboard'])->name('dashboard');
        Route::get('/submissions/{mahasiswa}', [DosenController::class, 'viewSubmissions'])->name('submissions'); // {mahasiswa} adalah User model
        Route::patch('/grade/{document}', [DosenController::class, 'gradeDocument'])->name('grade'); // {document} adalah Document model
    });
});

require __DIR__.'/auth.php';
