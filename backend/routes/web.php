<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HeroSectionController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\TestimonialsController;
use App\Http\Controllers\WebsiteSettingsController;
use App\Http\Controllers\BannersController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\PackagesController;
use App\Http\Controllers\UsersController;

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


Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'root']);
Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');

Route::middleware(['auth','admin'])->prefix('admin')->group(function () {
    // Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //Hero Sections
    Route::resource('hero_sections', HeroSectionController::class);

    //Services
    Route::resource('services', ServicesController::class);

    //Testimonials
    Route::resource('testimonials', TestimonialsController::class);

    //Website Settings
    Route::resource('website_settings', WebsiteSettingsController::class);

    //Banners
    Route::resource('banners', BannersController::class);

    //Sections
    Route::resource('sections', SectionsController::class);

    //Packages
    Route::resource('packages', PackagesController::class);

    //users
    Route::resource('users', UsersController::class);
});