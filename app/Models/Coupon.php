<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Coupon extends Model
{
	protected $fillable = [
		'par_value',
		'more_value',
		'title',
		'quantum',
		'receive',
		'start_at',
		'end_at',
		'status',
	];

	public function users()
	{
		return $this->belongsToMany(User::class,'user_coupons','coupon_id','user_id');
	}

	//优惠券有效期检查计划
	public function checkCouponValidate()
    {
    	$nowTime=Carbon::now();
    	$isValidateCoupons=self::where('status',1)->get()->pluck('id','end_at');
    	//todo..
    }
}
