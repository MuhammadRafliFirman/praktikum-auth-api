<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController; // Tambahkan ini
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Route dashboard yang sudah diproteksi middleware auth
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Semua route di dalam group ini hanya bisa diakses setelah login
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Tambahkan Route Resource untuk Product di sini
    Route::resource('products', ProductController::class);
});

require __DIR__.'/auth.php';