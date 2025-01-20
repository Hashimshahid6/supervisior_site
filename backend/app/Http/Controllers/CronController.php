<?php

namespace App\Http\Controllers;

use App\Models\HeroSection;
use App\Models\Sections;
use App\Models\Services;
use App\Models\Testimonials;
use App\Models\Banners;
use App\Models\WebsiteSettings;
use App\Models\ContactUs;
use App\Models\User;
use App\Models\Packages;
use App\Models\Payments;
use App\Models\PaymentVaultInfo;
use App\Models\UserSubscriptions;
use App\Mail\ForgotPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Services\PayPalService;
use Laravel\Sanctum\PersonalAccessToken;
use Auth;

class CronController extends Controller
{
    public function userPackageStatusCheck(){
        $users = User::where([['status','Active'],['role','Company'],['package_status','Active']])->with(['payment' => function ($query) {
            $query->where('payment_status', 'Completed');
        }])->get(); 
        $updated_count = 0;
        if($users != null){
            foreach($users as $each_user){
                if(count($each_user->payment) > 0){
                    if($each_user->payment[0]->end_date == date('Y-m-d')){
                        $each_user->package_status = 'Inactive';
                        $each_user->save();
                        $updated_count++;
                    } // end if payment date matches today
                } // end if user payment exists        
            } // end foreach users
            return response()->json([$updated_count." Users Updated"], 200);
        } // end if users exists
    }// end function
}