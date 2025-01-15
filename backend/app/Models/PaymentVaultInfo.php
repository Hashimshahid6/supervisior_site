<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentVaultInfo extends Model
{
	protected $table = 'payment_vault_info';
	protected $fillable = ['user_id','payment_id','order_id','vault_id','customer_id'];
} //
