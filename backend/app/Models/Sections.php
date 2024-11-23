<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sections extends Model
{
    protected $table = 'sections';
    protected $fillable = [
        'heading',
        'subheading',
        'content',
        'image',
        'button_text',
        'button_link',
        'display_on',
        'order',
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
    }//


    public static function getSections()
    {
        return self::all();
    }//
}
