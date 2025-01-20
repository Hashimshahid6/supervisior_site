<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Auth;
use Hash;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'user_id',
        'package_id',
        'email',
        'password',
        'phone',
        'role',
        'avatar',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->created_by = auth()->id();
        });
        self::updating(function ($model) {
            $model->updated_by = auth()->id();
        });
    }

    public function package()
    {
        return $this->hasOne(Packages::class, 'id', 'package_id');
    }

    public function projects()
    {
        return $this->hasMany(Projects::class);
    }

    public function messages()
    {
        return $this->hasMany(Messages::class);
    }
		public function parent()
    {
        return $this->belongsTo(User::class, 'company_id');
    }

    public function children()
    {
        return $this->hasMany(User::class, 'company_id');
    }

    public function payment()
    {
        return $this->hasMany(Payments::class);
    }

    public static function getAllUsers()
    {
        $query = User::query();

        if (auth()->user()->role == 'Admin') {
            $query->with(['projects', 'package', 'payment'])->where('status', 'Active');
        } else {
            $query->where('status', 'Active')
                ->where('created_by', auth()->id());
        }

        if (request()->has('search') && request()->search != '') {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . request()->search . '%')
                    ->orWhere('email', 'like', '%' . request()->search . '%')
                    ->orWhere('phone', 'like', '%' . request()->search . '%');
            });
        }

        if (request()->has('role') && request()->role != '') {
            $query->where('role', request()->role);
        }

        if (request()->has('status') && request()->status != '') {
            $query->where('status', request()->status);
        }

        if (request()->has('package_id') && request()->package_id != '') {
            $query->where('package_id', request()->package_id);
        }

        if (request()->has('sort_by') && request()->has('sort_order')) {
            $query->orderBy(request()->sort_by, request()->sort_order);
        } else {
            $query->orderBy('id', 'desc');
        }

        return $query;
    }
    public static function LoginUser()
    {
        request()->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
				// $user = Auth::user();
				// dd($user);
				// Log out the current user if any
				if (Auth::guard('web')->check()) {
						Auth::guard('web')->logout();
				} // Log out the current user if any
        // Attempt to log the user in using the 'web' guard
        if (Auth::guard('web')->attempt(['email' => request()->email, 'password' => request()->password])) {
            // $user = Auth::user();
						// Manually retrieve the logged-in user
        		$user = Auth::guard('web')->user()->load('parent', 'children');
						if($user->parent != null){
							if($user->parent->package_status == 'Inactive'){
								return response()->json(['message' => 'Company Package expired.'], 401);
								// logout the user again
								if ($user) {
									$user->tokens()->delete(); // Revoke all tokens
								} // Revoke all tokens
								Auth::guard('web')->logout();
							}
						} //
    
            // Generate an API token for React frontend
            $token = $user->createToken('auth_token')->plainTextToken;
    
            // Set the session cookie
            $cookie = cookie('laravel_session', session()->getId(), config('session.lifetime'), '/', config('session.domain'), config('session.secure'), true);
    
            return response()->json([
                'message' => 'Login successful',
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user,
            ])->cookie($cookie);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }
		public static function RegisterUser()
		{
			request()->validate([
					'name' => 'required|string|max:255',
					'email' => 'required|email|unique:users',
					'password' => 'required|min:8|confirmed',
			]);
			$avatarNumber = rand(1, 4).'.jpg';
			// Create a new user
			$user = User::create([
					'name' => request()->name,
					'role' => 'Company',
					'avatar' => 'avatar-'.$avatarNumber,
					'email' => request()->email,
					'password' => Hash::make(request()->password),
			]);

			// Generate token for the user
			$token = $user->createToken('auth_token')->plainTextToken;

			return response()->json([
					'message' => 'User registered successfully',
					'access_token' => $token,
					'token_type' => 'Bearer',
					'user' => $user,
			], 201);
		}
}