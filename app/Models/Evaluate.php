<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluate extends Model
{
    protected $fillable=[
		'order_id',
		'order_item_id',
		'product_id',
		'content',
		'images',
		'status',
    ];

    public function product()
    {
    	return $this->belongsTo(Product::class);
    }

    public function setImagesAttribute($images)
    {
    	if (is_array($images)) {

			$this->attributes['images'] = json_encode($images);
		}
    }

    public function getImagesAttribute($images)
    {
    	return json_decode($images, true);
    }

}
