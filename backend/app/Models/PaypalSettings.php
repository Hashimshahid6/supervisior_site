<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaypalSettings extends Model
{
    protected $table = 'paypal_settings';

    protected $fillable = [
        'endpoint',
        'client_id',
        'client_secret',
        'mode',
        'status',
    ];

    public static function getAllPaypalSettings()
    {
        return self::all();
    }
}
