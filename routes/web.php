<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\AuthController;  

// Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
// Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
// Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route::middleware('auth')->group(function () {
//     Route::get('/order', [OrderController::class, 'index'])->name('order.index');
//     Route::get('/item', [ItemController::class, 'index'])->name('item.index');
//     Route::get('/users', [UserController::class, 'index'])->name('users.index');
// });

Route::get('/order', [OrderController::class, 'index'])->name('order.index');        
Route::get('/order/create', [OrderController::class, 'create'])->name('order.create');
Route::post('/order', [OrderController::class, 'store'])->name('order.store');        
Route::get('/order/edit/{id}', [OrderController::class, 'edit'])->name('order.edit');
Route::put('/order/{id}', [OrderController::class, 'update'])->name('order.update');  
Route::get('/order/{id}/images', [OrderController::class, 'images'])->name('order.images');
Route::delete('/order/delete/{id}', [OrderController::class, 'destroy'])->name('order.destroy');

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/delete/{id}', [userController::class, 'destroy'])->name('users.destroy');

Route::get('/item', [ItemController::class, 'index'])->name('item.index');         
Route::get('/item/create', [ItemController::class, 'create'])->name('item.create'); 
Route::post('/item/store', [ItemController::class, 'store'])->name('item.store');   
Route::get('/item/edit/{id}', [ItemController::class, 'edit'])->name('item.edit');
Route::put('/item/update/{id}', [ItemController::class, 'update'])->name('item.update');
Route::delete('/item/delete/{id}', [ItemController::class, 'destroy'])->name('item.destroy');

Route::post('/order/{orderId}/images', [OrderController::class, 'uploadImage'])->name('order.images.upload');
Route::delete('/images/{imageId}', [OrderController::class, 'deleteImage'])->name('order.images.delete');

Route::get('/', [WelcomeController::class, 'index']);

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

Route::get('/noje', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

require __DIR__.'/auth.php';
