<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuthenticationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HeroSectionController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\TestimonialsController;
use App\Http\Controllers\WebsiteSettingsController;
use App\Http\Controllers\BannersController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\PackagesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PlantChecklistController;
use App\Http\Controllers\VehicleChecklistController;
use App\Http\Controllers\ToolboxTalkController;
use Illuminate\Support\Facades\Artisan;

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

Route::get('/admin/login', [LoginController::class, 'index'])->name('login');
Route::post('/admin/login', [AuthenticationController::class, 'authenticate'])->name('login.post');
Route::get('/admin/register', [RegisterController::class, 'index'])->name('register');
Route::post('/admin/register', [RegisterController::class, 'register'])->name('register.post');
Route::get('/admin/update-password', [LoginController::class, 'updatePassword'])->name('password.update');
Route::post('/admin/update-password', [LoginController::class, 'updatePasswordPost'])->name('password.update.post');
Route::get('/admin/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/admin/cache-clear', function () {
    Artisan::call('route:clear');
    return "Cache is cleared";
});
Route::middleware(['auth','admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

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

    Route::get('projects/payment_intent', [ProjectsController::class, 'payment_intent'])->name('projects.payment_intent');	
    Route::get('projects/capturePayment/{orderId?}', [ProjectsController::class, 'capturePayment'])->where('orderId', '[a-zA-Z0-9]+');	
    Route::get('projects/retrievePaymentIntent/{orderId?}', [ProjectsController::class, 'retrievePaymentIntent'])->where('orderId', '[a-zA-Z0-9]+');	
    //projects
    Route::resource('projects', ProjectsController::class);

    //messages
    Route::resource('messages', MessagesController::class);

    //Plant Checklist
    Route::resource('plant_checklists', PlantChecklistController::class);

    //Vehicle Checklist
    Route::resource('vehicle_checklists', VehicleChecklistController::class);

    //Toolbox Talk Template
    Route::resource('toolbox_talks', ToolboxTalkController::class);
});