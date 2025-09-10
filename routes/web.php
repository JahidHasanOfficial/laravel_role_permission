<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DivisionController;
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

    //Posts
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{id}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');
    
   // Users
   Route::get('/users', [UserController::class, 'index'])->name('users.index');
   Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
   Route::post('/users', [UserController::class, 'store'])->name('users.store');
   Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
   Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
   Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

   //Divisions
   Route::get('/divisions', [DivisionController::class, 'index'])->name('divisions.index');
   Route::get('/divisions/create', [DivisionController::class, 'create'])->name('divisions.create');
   Route::post('/divisions', [DivisionController::class, 'store'])->name('divisions.store');
   Route::get('/divisions/{id}/edit', [DivisionController::class, 'edit'])->name('divisions.edit');
   Route::put('/divisions/{id}', [DivisionController::class, 'update'])->name('divisions.update');
   Route::delete('/divisions/{id}', [DivisionController::class, 'destroy'])->name('divisions.destroy');









});

require __DIR__.'/auth.php';
