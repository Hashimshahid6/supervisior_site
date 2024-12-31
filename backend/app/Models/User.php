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
    }//
    public function package()
    {
        return $this->hasOne(Packages::class, 'id', 'package_id');
    }//

    public function projects()
    {
        return $this->hasMany(Projects::class);
    }//

    public function messages()
    {
        return $this->hasMany(Messages::class);
    }//

    public static function getAllUsers()
    {
        if (auth()->user()->role == 'Admin') {
            return User::with('projects', 'package')->where('status', 'Active')->get();
        } else {
            return User::where('status', 'Active')
                ->where('created_by', auth()->id())
                ->get();
        }
    }//

}
