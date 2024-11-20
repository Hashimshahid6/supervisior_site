<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanySettings extends Model
{
    protected $table = 'company_settings';
    protected $fillable = [
        'company_name',
        'company_email',
        'company_phone',
        'company_address',
        'company_city',
        'company_country',
        'company_postal_code',
        'company_logo',
        'company_favicon',
        'company_description',
        'company_facebook',
        'company_twitter',
        'company_instagram',
        'company_linkedin',
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

    public static function getAllCompanySettings()
    {
        return self::all();
    }
}
