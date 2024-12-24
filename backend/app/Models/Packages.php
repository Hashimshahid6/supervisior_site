<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Packages extends Model
{
    protected $table = 'packages';
    protected $fillable = ['name', 'description', 'price', 'trial_text', 'status'];

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
    } //

    public static function getAllPackages(){
        return self::all();
    }
}