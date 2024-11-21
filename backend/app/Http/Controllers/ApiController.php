<?php

namespace App\Http\Controllers;

use App\Models\HeroSection;
use App\Models\Services;
use Illuminate\Http\Request;

class ApiController extends Controller
{
  public function getHeroSectionFrontend(){
			$heroes = HeroSection::getHeroSectionFrontend();
			return response()->json([
				'data' => $heroes
				]);
	} //
	public function getServicesFrontend(){
			$services = Services::getServicesFrontend();
			return response()->json($services);
	} //
}
