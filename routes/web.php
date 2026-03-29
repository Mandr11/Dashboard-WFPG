<?php

use App\Http\Controllers\DatasetController;

Route::get('/menu-bundling', [App\Http\Controllers\DatasetController::class, 'menuBundling'])->name('dataset.menu_bundling');Route::get('/', [DatasetController::class, 'index'])->name('dataset.index');
Route::post('/upload', [DatasetController::class, 'store'])->name('dataset.store');
Route::delete('/dataset/{id}', [DatasetController::class, 'destroy'])->name('dataset.destroy');
Route::post('/analyze', [DatasetController::class, 'analyze'])->name('dataset.analyze');
Route::get('/hasil-analisis', [App\Http\Controllers\DatasetController::class, 'hasil'])->name('dataset.hasil');