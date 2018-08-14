<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductItem extends Model
{
   protected $fillable = [
	'product_id',
	'norm',
	'unit_price',
	'quantity',
	'status',
   ];

   public function product()
   {
   		return $this->belongsTo(Product::class);
   }
}
