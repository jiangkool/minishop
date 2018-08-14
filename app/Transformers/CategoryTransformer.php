<?php

namespace App\Transformers;

use App\Models\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{
    public function transform(Category $item)
    {
        return [
            'id' => $item->id,
            'title' => $item->title
        ];
    }
}