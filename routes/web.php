<?php

use App\Livewire\Auth\{Login, Logout, Password, Register};
use App\Livewire\Welcome;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::get('/login', Login::class)->name('login');
Route::get('/register', Register::class)->name('auth.register');
Route::get('/logout', Logout::class)->name('auth.logout');
Route::get('/password/recovery', Password\Recovery::class)->name('password.recovery');
Route::get('/password/reset', fn () => 'oi')->name('password.reset');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', Welcome::class)->name('dashboard');
});
