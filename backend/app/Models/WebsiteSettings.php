<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteSettings extends Model
{
    protected $table = 'website_settings';
    protected $fillable = [
        'site_name',
        'site_url',
        'site_email',
        'site_email2',
        'site_phone',
        'site_phone2',
        'site_address',
        'site_city',
        'site_country',
        'site_postal_code',
        'site_logo',
        'site_favicon',
        'site_description',
        'site_facebook',
        'site_twitter',
        'site_instagram',
        'site_linkedin',
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
    } //

    public static function getAllWebsiteSettings()
    {
        return self::all();
    } //

    public static function getWebsiteSettingsFrontend()
    {
        return self::select([
            'site_name',
            'site_url',
            'site_email',
            'site_phone',
            'site_address',
            'site_city',
            'site_country',
            'site_postal_code',
            'site_logo',
            'site_favicon',
            'site_description',
            'site_facebook',
            'site_twitter',
            'site_instagram',
            'site_linkedin',
        ]);
    } //
}