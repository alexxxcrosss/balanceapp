<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'form'])->name('loginform');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth')->group(function () {
    Route::get('/', [MainController::class, 'index'])->name('index');
    Route::get('/getdata', [MainController::class, 'getData'])->name('getdata');
    Route::get('/history', [MainController::class, 'history'])->name('history');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});