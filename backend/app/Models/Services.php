<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    protected $table = 'services';
    protected $fillable = [
        'title',
        'description',
        'button_text',
        'button_url',
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

		public static function getServicesFrontend(){
			return self::where('status','Active')->take(4)->get(['id','title','description','icon','bgImage']);
		} //
}
