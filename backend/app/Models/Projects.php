<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
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
        return $this->belongsTo(User::class);
    }//

    public function messages()
    {
        return $this->hasMany(Messages::class)->with('user');
    }

    public static function getAllProjects()
    {
        return Projects::with('user', 'messages')->where('status', 'Active')->get();
    }
}