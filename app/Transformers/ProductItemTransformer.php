<?php

namespace App\Transformers;

use App\Models\ProductItem;
use League\Fractal\TransformerAbstract;

class ProductItemTransformer extends TransformerAbstract
{
    public function transform(ProductItem $item)
    {
        return [
            'id' => $item->id,
            'stores' => $item->quantity,
            'price' => $item->unit_price,
            'diff_price' => $item->diff_price
        ];
    }


}