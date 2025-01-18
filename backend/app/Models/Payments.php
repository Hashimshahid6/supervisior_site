<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
	protected $table = 'payments';
	protected $fillable = ['user_id','package_id','amount','currency',
	'payment_status', 'payment_method', 'payment_response', 'cancelled_at',
	'completed_at', 'payment_capture_response', 'start_date', 'end_date'];

	public function user()
	{
		return $this->belongsTo(User::class, 'user_id');
	}

	public function package()
	{
		return $this->belongsTo(Packages::class, 'package_id');
	}//

	public static function getAllPayments()
	{
		$query = Payments::query();
		$query->with(['user', 'package']);

		if(auth()->user()->role == 'Company'){
			$query->where('user_id', auth()->id());
		}

		if(request()->has('search') && request()->search != ''){
			$search = request()->search;
			$query->whereHas('user', function($query) use($search){
				$query->where('name', 'LIKE', '%'.$search.'%')
				->orWhere('email', 'LIKE', '%'.$search.'%');
			});
		}

		if(request()->has('package_id') && request()->package_id != ''){
			$query->where('package_id', request()->package_id);
		}

		if(request()->has('payment_status') && request()->payment_status != ''){
			$query->where('payment_status', request()->payment_status);
		}

		if(request()->has('payment_method') && request()->payment_method != ''){
			$query->where('payment_method', request()->payment_method);
		}

		if(request()->has('start_date') && request()->start_date != ''){
			$query->where('start_date', '>=', request()->start_date);
		}

		if(request()->has('end_date') && request()->end_date != ''){
			$query->where('end_date', '<=', request()->end_date);
		}

		if (request()->has('sort_by') && request()->has('sort_order')) {
            $query->orderBy(request()->sort_by, request()->sort_order);
        } else {
            $query->orderBy('id', 'desc');
        }

		return $query;
	} //

} //
