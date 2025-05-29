<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

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
    return view('welcome'); // la vista resources/views/welcome.blade.php
});

Route::get('/about', function () {
    return view('about'); // crea este archivo blade para la página About
});

Route::get('/dashboard', function () {
    return view('dashboard'); // crea este archivo blade para la página About
});

require __DIR__.'/auth.php';
