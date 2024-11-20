<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HeroSectionController;

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

    Route::resource('hero_sections', HeroSectionController::class);
});