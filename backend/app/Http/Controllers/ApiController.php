<?php

namespace App\Http\Controllers;

use App\Models\HeroSection;
use App\Models\Sections;
use App\Models\Services;
use App\Models\Testimonials;
use App\Models\Banners;
use App\Models\WebsiteSettings;
use App\Models\ContactUs;
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

	public function getWebsiteSettings(){
		$settings = WebsiteSettings::getWebsiteSettingsFrontend();
		return response()->json($settings);
	}
	public function getWebsiteSections(){
		$settings = Sections::getSections();
		return response()->json($settings);
	}

	public function getAboutSection(){
		$settings = Sections::getAboutSection();
		return response()->json($settings);
	}
	public function getServiceSection(){
		$settings = Sections::getServiceSection();
		return response()->json($settings);
	}
	public function getAboutSectionone(){
		$settings = Sections::getAboutSectionone();
		return response()->json($settings);
	}
	public function getAboutSectiontwo(){
		$settings = Sections::getAboutSectiontwo();
		return response()->json($settings);
	}
	public function getAboutSectionthree(){
		$settings = Sections::getAboutSectionthree();
		return response()->json($settings);
	}
	public function getBannerId($id){
	    $banner = Banners::getBannerId($id);
		return response()->json($banner);
	}//
	public function contactus_form(){
        $save = ContactUs::save_contact_form();
		return response()->json($save);
	} //
}
