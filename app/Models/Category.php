<?php

namespace App\Models;

use Encore\Admin\Traits\AdminBuilder;
use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Traits\ModelTree;

class Category extends Model
{
	use ModelTree, AdminBuilder;
	public function __construct(array $attributes = [])
   {
       parent::__construct($attributes);

       $this->setParentColumn('parent_id');
       $this->setOrderColumn('sort');
       // $this->setTitleColumn('name');
   }
      protected $fillable = [
			'title',
			'icon',
			'parent_id',
			'sort',
			'status',
    ];

    public function scopeActive($query)
    {
      return $query->where('status',1);
    }

    public function scopeSort($query)
    {
      return $query->orderBy('sort','desc');
    }
}
