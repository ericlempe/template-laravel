<?php

use App\Enums\Can;
use App\Livewire\Admin\{Dashboard, Users};
use App\Livewire\Auth\{Login, Logout, Password, Register};
use App\Livewire\Welcome;
use Illuminate\Support\Facades\Route;

//region Guest
Route::redirect('/', '/login');
Route::get('/login', Login::class)->name('login');
Route::get('/register', Register::class)->name('auth.register');
Route::get('/logout', Logout::class)->name('auth.logout');
Route::get('/password/recovery', Password\Recovery::class)->name('password.recovery');
Route::get('/password/reset', Password\Reset::class)->name('password.reset');
//endregion

//region Authenticated
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', Welcome::class)->name('dashboard');

    //region Admin
    Route::prefix('/admin')->middleware('can:' . Can::BE_AN_ADMIN->value)->group(function () {
        Route::get('/dashboard', Dashboard::class)->name('admin.dashboard');

        Route::get('/users', Users\Index::class)->name('admin.users');
    });
    //endregion
});
//endregion
