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
	Route::get('homeservices', [ApiController::class,'getHomeServices']);
	Route::get('allservices', [ApiController::class,'getActiveServices']);
	Route::get('testimonials', [ApiController::class,'getTestimonialsFrontend']);
	Route::get('settings', [ApiController::class,'getWebsiteSettings']);
	Route::get('aboutsection', [ApiController::class,'getAboutSection']);
	Route::get('servicesection', [ApiController::class,'getServiceSection']);
	Route::get('aboutsectionone', [ApiController::class,'getAboutSectionone']);
	Route::get('aboutsectiontwo', [ApiController::class,'getAboutSectiontwo']);
	Route::get('aboutsectionthree', [ApiController::class,'getAboutSectionthree']);
	Route::get('getbanner/{id}', [ApiController::class,'getBannerId'])->where('id','[0-9]+');
	Route::post('contactus_form', [ApiController::class,'contactus_form']);
	Route::post('LoginUser', [ApiController::class,'LoginUser']);
	Route::post('RegisterUser', [ApiController::class,'RegisterUser']);
	Route::get('isLoggedIn', [ApiController::class,'isLoggedIn']);
	Route::get('LogoutUser', [ApiController::class,'LogoutUser'])->middleware('web');
	Route::post('createPaymentIntent', [ApiController::class,'createPaymentIntent']);
	Route::get('paypalCancelled', [ApiController::class,'paypalCancelled']);
	Route::get('doPaypalReturn', [ApiController::class,'doPaypalReturn']);
});