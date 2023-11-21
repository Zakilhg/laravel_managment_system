<?php
//
//use App\Http\Controllers\ProductController;
//use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\UsersAuthController;
//
////Route::get('/', function () {
////    return view('welcome');
////});
//
//Route::get('/', [UsersAuthController::class, 'home']);
//Route::get('dashboard', [UsersAuthController::class, 'dashboard'])->name('dashboard');
//Route::get('login', [UsersAuthController::class, 'index'])->name('login');
//Route::post('login', [UsersAuthController::class, 'login'])->name('login');
//Route::get('signup', [UsersAuthController::class, 'signup'])->name('register-user');
//Route::post('postsignup', [UsersAuthController::class, 'signupsave'])->name('postsignup');
//Route::get('signout', [UsersAuthController::class, 'signOut'])->name('signout');
//Route::post('update', [UsersAuthController::class, 'update'])->name('update');
//Route::get('edit', [UsersAuthController::class, 'edit'])->name('edit');
////Route::get('edit', [UsersAuthController::class, 'edit'])->name('edit')->middleware('auth');
//
//
//Route::get('/p/{id}',[ProductController::class,'show'])->name('product.show');


use App\Http\Controllers\ProductController;
use App\Http\Controllers\VentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersAuthController;

Route::get('/', [UsersAuthController::class, 'home']);


Route::middleware(['guest'])->group(function () {
    Route::get('login', [UsersAuthController::class, 'index'])->name('login');
    Route::post('login', [UsersAuthController::class, 'login'])->name('login');
    Route::get('signup', [UsersAuthController::class, 'signup'])->name('register-user');
    Route::post('postsignup', [UsersAuthController::class, 'signupsave'])->name('postsignup');
});

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [UsersAuthController::class, 'dashboard'])->name('dashboard');
    Route::post('update', [UsersAuthController::class, 'update'])->name('update');
    Route::get('edit', [UsersAuthController::class, 'edit'])->name('edit');
    Route::get('signout', [UsersAuthController::class, 'signOut'])->name('signout');
    Route::get('/p/{id}',[ProductController::class,'show'])->name('product.show');
    Route::get('/p',[ProductController::class,'index'])->name('product.index');
    Route::resource('vent',VentController::class);
    Route::get('/getProductInfo/{id}', [ProductController::class,'getProductInfo']);
    Route::get('/sales', [VentController::class,'index'])->name('sales');
    Route::get('/profile', [UsersAuthController::class,'profile'])->name('profile');
});



//Route::get('/hero',[ProductController::class,'index'])->name('product.hero');

