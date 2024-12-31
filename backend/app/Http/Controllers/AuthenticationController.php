<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthenticationController extends Controller
{
  public function authenticate(Request $request){
		$validator = Validator::make($request->all(), [
			'email' => 'required|email',
			'password' => 'required'
		]);
		if($validator->fails()){
			return response()->json([
				'status' => false,
				'errors' => $validator->errors()
			]);
		}
		$credentials = [
			'email'=> $request->email,
			'password'=> $request->password
		];
		if(\Auth::attempt($credentials)){
			$user = User::find(\Auth::user()->id);
			$token = $user->createToken('token')->plainTextToken;
			if($user->role == 'Employee'){
				return redirect()->route('projects.index');
			}else{
				return redirect()->route('dashboard');
			}
		}else{
            session()->flash('error', 'Invalid email or password');
            return redirect()->route('login');
		}
	}
}
