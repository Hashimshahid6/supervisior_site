<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
	protected $table = 'payments';
	protected $fillable = ['user_id','package_id','amount','currency','payment_status','payment_method','payment_response','cancelled_at','completed_at','payment_capture_response'];
} //
