<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    use HasFactory;
    protected $table = 'messages';
    protected $fillable = ['projects_id', 'user_id', 'message', 'image'];


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
    
    public function project()
    {
        return $this->belongsTo(Projects::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getAllMessages($project_id)
    {
        return Messages::with('user')->where('projects_id', $project_id)->get();
    }
}
