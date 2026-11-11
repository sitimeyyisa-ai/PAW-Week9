<?php

use App\Http\Controllers\RentalController;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\AuthController;

// Route Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'processLogin'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route yang dilindungi middleware auth
Route::middleware(['auth'])->group(function () {
    // Bisa diakses Admin & Staff
    Route::get('/', [RentalController::class, 'index'])->name('rental.index');
    Route::get('/rental/create', [RentalController::class, 'create'])->name('rental.create');
    Route::post('/rental', [RentalController::class, 'store'])->name('rental.store');
    Route::get('/rental/{id}/edit', [RentalController::class, 'edit'])->name('rental.edit');
    Route::put('/rental/{id}', [RentalController::class, 'update'])->name('rental.update');

    // HANYA ADMIN yang boleh menghapus data
    Route::delete('/rental/{id}', [RentalController::class, 'destroy'])
        ->middleware('role:admin')
        ->name('rental.destroy');
});