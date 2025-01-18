<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSubscriptions extends Model
{
	protected $table = 'user_subscriptions';
	protected $fillable = ['user_id','package_id','start_date','end_date'];
} //