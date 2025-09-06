<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
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

    // Permission
    Route::get('/permission', [PermissionController::class, 'index'])->name('permissions.index');
    Route::get('/permission/create', [PermissionController::class, 'create'])->name('permissions.create');
    Route::post('/permission', [PermissionController::class, 'store'])->name('permissions.store');
    Route::get('/permission/{id}/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
    Route::put('/permission/{id}', [PermissionController::class, 'update'])->name('permissions.update');
    Route::delete('/permission/{id}', [PermissionController::class, 'destroy'])->name('permissions.destroy');

    //role
    Route::get('/role', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/role/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/role', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/role/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('/role/{id}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/role/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');
    
});

require __DIR__.'/auth.php';
