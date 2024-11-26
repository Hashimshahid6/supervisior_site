<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banners extends Model
{
    protected $table = 'banners';
    protected $fillable = [
        'heading',
        'subheading',
        'display_on',
        'image',
        'status',
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

    public static function getBanners()
    {
        return self::all();
    }//
    public static function getBannerId($id){
        return self::where('id',$id)->first();
    } //
}
