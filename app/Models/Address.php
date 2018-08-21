<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
		'user_id',
		'consignee',
		'gender',
		'address',
		'phone',
		'city_str',
		'province_str',
		'district_str',
		'zipcode',
		'status'
    ];
}
