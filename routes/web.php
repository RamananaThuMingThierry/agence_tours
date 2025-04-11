<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LanguesController;
use App\Http\Controllers\AUTH\LoginController;
use App\Http\Controllers\ADMIN\UsersController;
use App\Http\Controllers\AUTH\RegisterController;
use App\Http\Controllers\ADMIN\DashboardController;
use App\Http\Controllers\AUTH\ResetPasswordController;
use App\Http\Controllers\AUTH\ForgetPasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', [LoginController::class, 'showLogin'])->name('login');

Route::group(['middleware' => 'guest'], function(){
    // Login
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');

    // Register
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

    Route::get('/forget-password', [ForgetPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forget-password', [ForgetPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset.form');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.reset');
});

Route::prefix('admin')->name('admin.')->middleware(['auth','check.status'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});

Route::middleware('auth')->group(function(){
    Route::get('/waiting/user', [UsersController::class, 'waiting'])->name('status.not.approuved');
    Route::post('/logout', [UsersController::class, 'logout'])->name('logout');
});


Route::middleware(['locale'])->group(function () {
    Route::get('lang/{lang}', [LanguesController::class, 'changeLanguage'])->name('lang');
});

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
