<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    protected $table = 'services';
    protected $fillable = [
        'title',
        'description',
        'icon',
        'bgImage',
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

    public static function getServices()
    {
        return self::all();
    }
}