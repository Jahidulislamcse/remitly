<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class,'showLogin'])->name('user.login');
    Route::post('/login', [AuthController::class,'userLogin'])->name('user.login.submit');

    Route::get('/admin-login', [AuthController::class,'showAdminLogin'])->name('admin.login');
    Route::post('/admin-login', [AuthController::class,'adminLogin'])->name('admin.login.submit');

});

Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class,'logout'])->name('user.logout');
    Route::post('/admin-logout', [AuthController::class,'adminLogout'])->name('admin.logout');

});