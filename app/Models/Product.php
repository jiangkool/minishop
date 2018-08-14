<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
   protected $fillable = [
		'category_id',
		'title',
		'images',
		'pre_price',
		'diff_price',
		'share_price',
		'sale_num',
		'description',
		'content',
		'type',
		'status',
    ];

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

	public function product_items()
	{
		return $this->hasMany(ProductItem::class);
	}

	public function evaluates()
	{
		return $this->hasMany(Evaluate::class);
	}

	public function scopeActive($query)
	{
		return $query->where('status',1);
	}
}
