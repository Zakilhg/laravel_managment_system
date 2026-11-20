<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UsersAuthController;
use App\Http\Controllers\VentController;
use Illuminate\Support\Facades\Route;

Route::get('/', [UsersAuthController::class, 'home']);

Route::middleware('guest')->group(function () {
    Route::get('login', [UsersAuthController::class, 'index'])->name('login');
    Route::post('login', [UsersAuthController::class, 'login']);
    Route::get('signup', [UsersAuthController::class, 'signup'])->name('register-user');
    Route::post('postsignup', [UsersAuthController::class, 'signupsave'])->name('postsignup');
});

Route::middleware('auth')->group(function () {
    Route::get('dashboard', [UsersAuthController::class, 'dashboard'])->name('dashboard');
    Route::get('profile', [UsersAuthController::class, 'profile'])->name('profile');
    Route::get('edit', [UsersAuthController::class, 'edit'])->name('edit');
    Route::post('update', [UsersAuthController::class, 'update'])->name('update');
    Route::post('signout', [UsersAuthController::class, 'signOut'])->name('signout');

    Route::get('p', [ProductController::class, 'index'])->name('product.index');
    Route::get('p/{id}', [ProductController::class, 'show'])->name('product.show');
    Route::get('getProductInfo/{id}', [ProductController::class, 'getProductInfo']);

    Route::resource('vent', VentController::class)->only(['create', 'store', 'destroy']);
    Route::get('sales', [VentController::class, 'index'])->name('sales');
});
