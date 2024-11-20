<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        #1 for admin and 0 for user
        if(!empty(Auth::check() && Auth::user()->type == 'Admin')){
            return $next($request);
        }else{
            Auth::logout();
            session()->flash('error', 'You are not authorized to access this page only admin can access');
            // return redirect()->route('auth-login.index');
        }
    }
}
