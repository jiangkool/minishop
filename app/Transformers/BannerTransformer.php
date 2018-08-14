<?php

namespace App\Transformers;

use App\Models\Banner;
use League\Fractal\TransformerAbstract;

class BannerTransformer extends TransformerAbstract
{
    public function transform(Banner $item)
    {
        return [
            'id' => $item->id,
            'title' => $item->title,
            'image' => \Config::get('app.url', 'default'). '/uploads/' . $item->image,
            'url' => $item->url
        ];
    }
}
