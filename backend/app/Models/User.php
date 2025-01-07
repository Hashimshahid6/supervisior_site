<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

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

    public static function getAllUsers()
    {
        $query = User::query();

        if (auth()->user()->role == 'Admin') {
            $query->with('projects', 'package')->where('status', 'Active');
        } else {
            $query->where('status', 'Active')
                ->where('created_by', auth()->id());
        }

        if(request()->has('search') && request()->search != ''){
            $query->where(function($q) {
                $q->where('name', 'like', '%'.request()->search.'%')
                  ->orWhere('email', 'like', '%'.request()->search.'%')
                  ->orWhere('phone', 'like', '%'.request()->search.'%');
            });
        }

        if(request()->has('role') && request()->role != ''){
            $query->where('role', request()->role);
        }

        if(request()->has('status') && request()->status != ''){
            $query->where('status', request()->status);
        }

        if(request()->has('package_id') && request()->package_id != ''){
            $query->where('package_id', request()->package_id);
        }

        if (request()->has('sort_by') && request()->has('sort_order')) {
            $query->orderBy(request()->sort_by, request()->sort_order);
        } else {
            $query->orderBy('id', 'desc');
        }

        return $query;
    }
}
