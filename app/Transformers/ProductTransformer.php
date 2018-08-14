<?php

namespace App\Transformers;

use App\Models\Product;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{
    public function transform(Product $item)
    {
        return [
            'id' => $item->id,
            'title' => $item->title,
            'pre_price' => $item->pre_price,
            'diff_price' => $item->diff_price,
            'sale_num' => $item->sale_num,
            'images' => \Config::get('app.url', 'default').'/uploads/'.$item->images['0']
        ];
    }

}