<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
   protected $fillable=[
		'user_id',
		'pay_id',
		'consignee',
		'phone',
		'address',
		'tradetotal',
		'preferentialtotal',
		'customerfreightfee',
		'total',
		'out_trade_no',
		'freightbillno',
		'status',
		'type',
		'remark',
   ]; 

   public function orderItems()
   {
   		return $this->hasMany(OrderItem::class,'order_id');
   }
}
