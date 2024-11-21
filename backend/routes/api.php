<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\HeroSectionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('authenticate', [AuthenticationController::class,'authenticate']);
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group(['middleware'=>['auth:sanctum']], function () {
	Route::get('herosections', [ApiController::class,'getHeroSectionFrontend']);
	Route::get('services', [ApiController::class,'getServicesFrontend']);
	Route::get('testimonials', [ApiController::class,'getTestimonialsFrontend']);
});
