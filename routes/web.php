<?php

use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ADMIN\TourController;
use App\Http\Controllers\AUTH\LoginController;
use App\Http\Controllers\ADMIN\BadgeController;
use App\Http\Controllers\ADMIN\UsersController;
use App\Http\Controllers\ADMIN\SlidesController;
use App\Http\Controllers\AUTH\LanguesController;
use App\Http\Controllers\AUTH\WaitingController;
use App\Http\Controllers\ADMIN\ProfileController;
use App\Http\Controllers\AUTH\RegisterController;
use App\Http\Controllers\ADMIN\DashboardController;
use App\Http\Controllers\ADMIN\GalleriesController;
use App\Http\Controllers\ADMIN\TourImagesController;
use App\Http\Controllers\FRONT\FrontofficeController;
use App\Http\Controllers\ADMIN\ReservationsController;
use App\Http\Controllers\ADMIN\TestimonialsController;
use App\Http\Controllers\AUTH\ResetPasswordController;
use App\Http\Controllers\AUTH\ForgetPasswordController;

Route::get('/', [FrontofficeController::class, 'index'])->name('frontoffice');
Route::get('/testimonials', [FrontofficeController::class, 'testimonials'])->name('testimonials');
Route::get('/tours', [FrontofficeController::class, 'tours'])->name('tours');
Route::post('/frontoffice/reservation', [ReservationsController::class, 'store'])->name('reservation');

Route::get('lang/{lang}', [LanguesController::class, 'changeLanguage'])->name('lang');

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

Route::middleware('auth')->group(function(){
    Route::get('/waiting/user', [WaitingController::class, 'waiting'])->name('status.not.approuved');
    Route::post('/logout', [UsersController::class, 'logout'])->name('logout');
});

Route::prefix('backoffice')->name('admin.')->middleware(['auth','check.status'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/badge',[BadgeController::class, 'getAll'])->name('badge');
    Route::resource('gallery', GalleriesController::class);
    Route::resource('tours', TourController::class);
    Route::resource('slides', SlidesController::class);
    Route::resource('reservations', ReservationsController::class);
    Route::resource('tour-images', TourImagesController::class);
    Route::resource('testimonials', TestimonialsController::class);
    Route::resource('users', UsersController::class);
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
});

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});


Route::get('/sitemap', function () {
    $sitemap = Sitemap::create()
        ->add(Url::create('/'))
        ->add(Url::create('/tours'))
        ->add(Url::create('/testimonials'));

    $sitemap->writeToFile(public_path('sitemap.xml'));

    return 'Sitemap generated';
});