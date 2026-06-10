<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HibahController;




Route::controller(AuthController::class)->group(function () {
    Route::get('/', 'login')->name('login');
    Route::post('/loginproses', 'loginproses')->name('loginproses');
    Route::get('/logout', 'logout')->name('logout');
});

Route::middleware(['auth', 'checkrole'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('hibah/detail', [HibahController::class, 'detail'])->name('hibah.detail');
    Route::get('hibah/rekap', [HibahController::class, 'rekap'])->name('hibah.rekap');
    
    Route::get('user', [UserController::class, 'index'])->name('user.index');
    Route::get('user/{user}', [UserController::class, 'show'])->name('user.show');
    
    Route::get('hibah', [HibahController::class, 'index'])->name('hibah.index');
    Route::get('hibah/{hibah}', [HibahController::class, 'show'])->name('hibah.show');

    Route::middleware('checkadmin')->group(function () {
        Route::get('user/{user}/update-password', [UserController::class, 'showUpdatePasswordForm'])->name('user.updatePasswordForm');
        Route::put('user/{user}/update-password', [UserController::class, 'updatePassword'])->name('user.updatePassword');
        Route::resource('user', UserController::class)->except(['index', 'show']);
        Route::resource('hibah', HibahController::class)->except(['index', 'show']);
    });
});
