<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PermissionController;

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

        Route::get('/permission', [PermissionController::class, 'index'])->name('permissions.index');
        Route::get('/permission/create', [PermissionController::class, 'create'])->name('permissions.create');
        Route::post('/permission', [PermissionController::class, 'store'])->name('permissions.store');
        Route::get('/permission/{id}/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
     Route::put('/permission/{id}', [PermissionController::class, 'update'])->name('permissions.update');


        Route::delete('/permission/{id}', [PermissionController::class, 'destroy'])->name('permissions.destroy');
});

require __DIR__.'/auth.php';
