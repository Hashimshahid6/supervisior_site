<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonials extends Model
{
    protected $table = 'testimonials';
    protected $fillable = ['name', 'designation', 'avatar', 'bgImage', 'description', 'status'];

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

    public static function getTestimonials()
    {
        return self::all();
    }
    public static function getTestimonialsFrontend()
    {
        return self::where('status', 'Active')->take(3)->get(['name','designation','avatar','bgImage','description']);
    }
}
