<?php

namespace App\Transformers;

use App\Models\Product;
use League\Fractal\TransformerAbstract;

class ProductShowTransformer extends TransformerAbstract
{
    public function transform(Product $item)
    {
        return [
            'id' => $item->id,
            'title' => $item->title,
            'pre_price' => $item->pre_price,
            'diff_price' => $item->diff_price,
            'sale_num' => $item->sale_num,
            'minPrice'=>collect($item->product_items)->min('unit_price'),
            'total' => collect($item->product_items)->sum('quantity'),
            'images' => $this->changeUrl($item->images),
            'properties'=>$item->product_items,
            'comments_num'=>collect($item->evaluates)->count(),
            'content'=>$item->content,
            'share_price'=>$item->share_price
        ];
    }

    public function changeUrl($arr)
    {
        return array_map(function($item){
            return \Config::get('app.url', '').'/uploads/'.$item;
        }, $arr);
    }

}