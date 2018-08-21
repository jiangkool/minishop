<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable=[
		'user_id',
		'order_id',
		'product_id',
		'title',
		'norm',
		'pic',
		'num',
		'pre_price',
		'total_price',
    ];

    public function order()
    {
    	return $this->belongsTo(Order::class,'order_id');
    }
}
