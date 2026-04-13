<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DatasetController;
use App\Http\Controllers\AuthController;

// --- RUTE AUTENTIKASI (Bebas diakses) ---
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- RUTE DASHBOARD (Dikunci menggunakan middleware 'auth') ---
Route::middleware('auth')->group(function () {
    
    // Rute default arahkan ke Manajemen Dataset
    Route::get('/', [DatasetController::class, 'index'])->name('dataset.index');
    
    // Rute Dataset & Analisis
    Route::post('/dataset/store', [DatasetController::class, 'store'])->name('dataset.store');
    Route::delete('/dataset/{id}', [DatasetController::class, 'destroy'])->name('dataset.destroy');
    Route::post('/analyze', [DatasetController::class, 'analyze'])->name('dataset.analyze');
    Route::get('/hasil-analisis', [DatasetController::class, 'hasil'])->name('dataset.hasil');
    
    // Rute Menu Bundling
    Route::get('/menu-bundling', [DatasetController::class, 'menuBundling'])->name('dataset.menu_bundling');
});