<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\User\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'index'])->name('auth');
    Route::post('/auth/check', [AuthController::class, 'check'])->name('auth.check');
});

Route::get('auth/logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::prefix('administrator')->middleware('auth')->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::get('', [DashboardController::class, 'index'])->name('dashboard');
    });

    Route::prefix('users')->group(function () {
        Route::get('', [UserController::class, 'index'])->name('users');
        Route::get('getData', [UserController::class, 'getData'])->name('users.getData');
        Route::get('create', [UserController::class, 'create'])->name('users.create');
        Route::post('store', [UserController::class, 'store'])->name('users.store');
        Route::get('{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::post('{user}/update', [UserController::class, 'update'])->name('users.update');
        Route::delete('{user}/delete', [UserController::class, 'destroy'])->name('users.destroy');
    });


    Route::get('update-profile', [UserController::class, 'viewUpdateProfile'])->name('update-profile');
    Route::post('update-profile/{user}', [UserController::class, 'updateProfile'])->name('update-profile.form');
    Route::get('update-password', [UserController::class, 'viewUpdatePassword'])->name('update-password');
    Route::post('update-password/{user}', [UserController::class, 'updatePassword'])->name('update-password.form');
});
