<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Projects extends Model
{
    use HasFactory;
    protected $table = 'projects';
    protected $fillable = ['user_id', 'name', 'description', 'file', 'status'];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->created_by = auth()->id();
        });
        self::updating(function ($model) {
            $model->updated_by = auth()->id();
        });
    } //

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }//

    public function messages()
    {
        return $this->hasMany(Messages::class)->with('user');
    }

    public function plantChecklists()
    {
        return $this->hasMany(PlantChecklist::class);
    }

    public static function getAllProjects()
    {
        $user = auth()->user();

        if ($user->role == 'Admin') {
            return Projects::with('user', 'messages')->where('status', 'Active')->get();
        } elseif ($user->role == 'Company') {
            return Projects::with('user', 'messages')
                ->where('status', 'Active')
                ->where('user_id', $user->id)
                ->get();
        } elseif ($user->role == 'Employee') {
            return Projects::with('user', 'messages')
                ->where('status', 'Active')
                ->whereHas('user', function ($query) use ($user) {
                    $query->where('role', 'Company')
                          ->where('id', $user->user_id);
                })
                ->get();
        } else {
            return collect(); // Return an empty collection if the role doesn't match
        }
    }//
}
