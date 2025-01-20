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
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
	public function getHeroSectionFrontend()
	{
		$heroes = HeroSection::getHeroSectionFrontend();
		return response()->json([
			'data' => $heroes
		]);
	} //
	public function getHomeServices()
	{
		$services = Services::getHomeServices();
		return response()->json($services);
	} //
	public function getActiveServices()
	{
		$services = Services::getActiveServices();
		return response()->json($services);
	} //
	public function getTestimonialsFrontend()
	{
		$testimonials = Testimonials::getTestimonialsFrontend();
		return response()->json($testimonials);
	} //

	public function getWebsiteSettings()
	{
		$settings = WebsiteSettings::getWebsiteSettingsFrontend();
		return response()->json($settings);
	}
	public function getWebsiteSections()
	{
		$settings = Sections::getSections();
		return response()->json($settings);
	}

	public function getAboutSection()
	{
		$settings = Sections::getAboutSection();
		return response()->json($settings);
	}
	public function getServiceSection()
	{
		$settings = Sections::getServiceSection();
		return response()->json($settings);
	}
	public function getAboutSectionone()
	{
		$settings = Sections::getAboutSectionone();
		return response()->json($settings);
	}
	public function getAboutSectiontwo()
	{
		$settings = Sections::getAboutSectiontwo();
		return response()->json($settings);
	}
	public function getAboutSectionthree()
	{
		$settings = Sections::getAboutSectionthree();
		return response()->json($settings);
	}
	public function getBannerId($id)
	{
		$banner = Banners::getBannerId($id);
		return response()->json($banner);
	} //
	public function contactus_form()
	{
		$save = ContactUs::save_contact_form();
		return response()->json($save);
	} //
	public function LoginUser()
	{
		$login = User::LoginUser();
		return $login;
	}
	public function forgotPassword(Request $request)
	{
		$email = $request->email;
		$user_exist = User::where('email',$email)->first();
		if($user_exist == null){
			return response()->json(['message' => 'Invalid Email'], 404);
		} //
		// return response()->json(['message' => $user_exist], 200);
		$new_password = $this->generate_random_password();
		$new_password_hashed = \Hash::make($new_password);
		$user_exist->password = $new_password_hashed;
		$user_exist->save();
		// send email to user
		$settings = WebsiteSettings::getWebsiteSettingsFrontend();
		\Mail::to($user_exist->email)->send(new ForgotPassword($user_exist, $settings, $new_password));
		return response()->json(['message' => 'Password Recovered Successfully.'.$new_password], 200);		
	} //
	public function generate_random_password(){
		return random_int(100000, 999999);	
	}//
	public function RegisterUser()
	{
		$register = User::RegisterUser();
		return response()->json($register);
	}
	public function isLoggedIn(Request $request)
	{
		$token = $request->bearerToken();
		// Check if the token exists and retrieve its details
		$accessToken = PersonalAccessToken::findToken($token);
		if (!$accessToken) {
			return response()->json(['message' => 'Invalid token'], 401);
		}
		// Retrieve the associated user
		$user = $accessToken->tokenable; // This gets the user (or model) linked to the token
		if (!$user) {
			return response()->json(['message' => 'User not found'], 404);
		}
		// Optional: Check if the user is active or logged in (custom logic can go here)
		if (!$user->status == 'Active') { // Assuming you have an `is_active` column
			return response()->json(['message' => 'User account is inactive'], 403);
		}
		// Return success response
		return response()->json(['message' => 'Authenticated', 'user' => $user], 200);
	}
	public function LogoutUser()
	{
		$user = Auth::guard('web')->user();
		if ($user) {
			$user->tokens()->delete(); // Revoke all tokens
		} // Revoke all tokens
		Auth::guard('web')->logout();
		// Clear the laravel_session cookie
		$cookie = Cookie::forget('laravel_session');
		return response()->json(['message' => 'Logged out successfully'], 200);
	}
	// payment functions
	public function createPaymentIntent(Request $request)
	{
		$amount = $request->post('amount');
		$currency = $request->post('currency');
		$package = Packages::where('id', $request->post('package'))->first();
		$token = $request->bearerToken();
		// Check if the token exists and retrieve its details
		$accessToken = PersonalAccessToken::findToken($token);
		if (!$accessToken) {
			return response()->json(['message' => 'Invalid token'], 401);
		}
		// Get the user associated with the token
		$user = $accessToken->tokenable;
		// Create a new payment record in the database
		$payment = new Payments();
		$payment->user_id = $user->id;
		$payment->package_id = $package->id;
		$payment->amount = $amount;
		$payment->currency = $currency;
		$payment->payment_status = 'Pending'; // or 'completed', 'failed', etc.
		$payment->save();
		$paymentIntent = new PayPalService();
		$paymentIntent = $paymentIntent->createPaymentIntent($package, $amount, $currency);
		// Save PayPal response in the database
		$payment->payment_response = json_encode($paymentIntent);
		$payment->save();
		return response()->json($paymentIntent);
		// $payments_row = Payments::find(3);
		// $paymentIntent = $payments_row->payment_response;
		// // Decode the string as JSON, if it's stored as a JSON string in the database
		// $decodedResponse = json_decode($paymentIntent, true);
		// // Return it as a JSON response
		// return response()->json($decodedResponse);
	} //
	public function paypalCancelled()
	{
		$token = request()->bearerToken();
		// Check if the token exists and retrieve its details
		$accessToken = PersonalAccessToken::findToken($token);
		if (!$accessToken) {
			return response()->json(['message' => 'Invalid token'], 401);
		} //
		// Get the user associated with the token
		$user = $accessToken->tokenable;
		// Get the payment record from the database
		$paypal_token = request()->get('paypal_token');
		$payment = Payments::whereRaw("JSON_UNQUOTE(JSON_EXTRACT(payment_response, '$.id')) = ?", [$paypal_token])->first();
		if ($payment) {
			if ($payment->user_id != $user->id) {
				return response()->json(['message' => 'Unauthorized'], 403);
			}
			if ($payment->payment_status != 'Pending') {
				return response()->json(['message' => 'Payment already Processed'], 403);
			}
			$payment->payment_status = 'Cancelled';
			$payment->cancelled_at = date('Y-m-d H:i:s');
			$payment->save();
			return response()->json($payment);
		} else {
			return response()->json(['message' => 'Payment not found'], 404);
		}
	} //
	public function doPaypalReturn()
	{
		$token = request()->bearerToken();
		// Check if the token exists and retrieve its details
		$accessToken = PersonalAccessToken::findToken($token);
		if (!$accessToken) {
			return response()->json(['message' => 'Invalid token'], 401);
		} //
		// Get the user associated with the token
		$user = $accessToken->tokenable;
		// Get the payment record from the database
		$paypal_token = request()->get('paypal_token');
		$payment = Payments::whereRaw("JSON_UNQUOTE(JSON_EXTRACT(payment_response, '$.id')) = ?", [$paypal_token])->first();
		if ($payment) {
			// if($payment->payment_status == 'Pending'){
			// $payments_row = Payments::find(8);
			// $capture_response = $payments_row->payment_capture_response;
			$capturePayment = new PayPalService();
			$capture_response = $capturePayment->capturePayment($paypal_token);
			if (is_string($capture_response)) {
				$capture_response = json_decode($capture_response, true);
			} //
			if (json_last_error() !== JSON_ERROR_NONE) {
				// Handle JSON decode error
				throw new Exception('Error decoding API response: ' . json_last_error_msg());
			} //
			$payment->payment_capture_response = json_encode($capture_response);
			// $payment->payment_capture_response = $capture_response;
			$payment->payment_status = 'Completed';
			$payment->completed_at = date('Y-m-d H:i:s');
			$payment->save();
			// update package_id in users table
			$user->package_id = $payment->package_id;
			$user->save();
			// $capture_response = json_decode($capture_response, true);
			if (array_key_exists('payment_source', $capture_response)) {
				$vault_status = $capture_response['payment_source']['paypal']['attributes']['vault']['status'];
				if ($vault_status == 'VAULTED') {
					PaymentVaultInfo::create([
						'user_id' => $user->id,
						'order_id' => $capture_response['id'],
						'payment_id' => $payment->id,
						'vault_id' => $capture_response['payment_source']['paypal']['attributes']['vault']['id'],
						'customer_id' => $capture_response['payment_source']['paypal']['attributes']['vault']['customer']['id']
					]);
					// UPDATE PAYPAL VAULT ID AND CUSTOMER ID IN USERS TABLE
					$user->paypal_vault_id = $capture_response['payment_source']['paypal']['attributes']['vault']['id'];
					$user->paypal_customer_id = $capture_response['payment_source']['paypal']['attributes']['vault']['customer']['id'];
					$user->save();
					// SAVE TO USER SUBSCRIPTIONS TABLE
					UserSubscriptions::create([
						'user_id' => $user->id,
						'package_id' => $payment->package_id,
						'start_date' => date('Y-m-d H:i:s'),
						'end_date' => date('Y-m-d H:i:s', strtotime('+3 months'))
					]);
					// $user_subscription = new UserSubscriptions();
					// $user_subscription->user_id = $user->id;
					// $user_subscription->package_id = $payment->package_id;
					// $user_subscription->start_date = date('Y-m-d H:i:s');
					// $user_subscription->end_date = date('Y-m-d H:i:s', strtotime('+3 months'));
					// $user_subscription->save();
				}
			}
			return response()->json(['message' => 'Payment Processed Successfully'], 200);
			// }else{
			// 	return response()->json(['message' => 'Payment already Processed'], 403);
			// }
		} else {
			return response()->json(['message' => 'Payment not found'], 404);
		}
	}
}
