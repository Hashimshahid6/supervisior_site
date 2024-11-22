<?php

namespace App\Http\Controllers;

use App\Models\HeroSection;
use App\Models\Services;
use App\Models\Testimonials;
use Illuminate\Http\Request;

class ApiController extends Controller
{
  public function getHeroSectionFrontend(){
			$heroes = HeroSection::getHeroSectionFrontend();
			return response()->json([
				'data' => $heroes
				]);
	} //
	public function getHomeServices(){
			$services = Services::getHomeServices();
			return response()->json($services);
	} //
	public function getActiveServices(){
			$services = Services::getActiveServices();
			return response()->json($services);
	} //
	public function getTestimonialsFrontend(){
			$testimonials = Testimonials::getTestimonialsFrontend();
			return response()->json($testimonials);
	} //
}
