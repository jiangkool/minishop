<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recommend extends Model
{
    protected $fillable=[
			'user_id',
			'parent_id',
			'recommend_num',
			'visit_num',
			'qr_code',
    ];
}
