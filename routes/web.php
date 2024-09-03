<?php

namespace App\Http\Controllers;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\admin\AdminDashboardController;
use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\AdminStoreController;
use App\Http\Controllers\admin\AdminProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
//Route::get('/register', [LoginController::class, 'register']);
Route::group(['prefix' => 'account'], function () {
    //guest middleware
    Route::group(['middleware' => 'guest'], function () {
        Route::get('login', [LoginController::class, 'index'])->name('account.login');
        Route::get('register', [LoginController::class, 'register'])->name('account.register');
        Route::post('process-register', [LoginController::class, 'processRegister'])->name('account.processRegister');
        Route::post('authenticate', [LoginController::class, 'authenticate'])->name('account.authenticate');
    });
    //authenticated middleware
    Route::group(['middleware' => 'auth'], function () {
        Route::get('logout', [LoginController::class, 'logout'])->name('account.logout');
        Route::get('dashboard', [DashboardController::class, 'index'])->name('account.dashboard');
    });
});


Route::group(['prefix' => 'admin'], function () {
    //guest middleware for admin
    Route::group(['middleware' => 'admin.guest'], function () {
        Route::get('login', [AdminLoginController::class, 'index'])->name('admin.login');
        Route::post('authenticate', [AdminLoginController::class, 'authenticate'])->name('admin.authenticate');
    });
    //authenticated middleware for admin
    Route::group(['middleware' => 'admin.auth'], function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
        Route::post('store', [AdminDashboardController::class, 'store'])->name('admin.store');
        Route::get('fetchall', [AdminDashboardController::class, 'fetchAll'])->name('fetchAll');
        Route::get('edit', [AdminDashboardController::class, 'edit'])->name('edit');
        Route::post('update', [AdminDashboardController::class, 'update'])->name('update');
        Route::post('delete', [AdminDashboardController::class, 'delete'])->name('delete');
    });
});
