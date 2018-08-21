<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $item)
    {
        return [
            'id' => $item->id,
            'nickname' => $item->nickname,
            'victory_total' => $item->victory_total,
            'victory_current' => $item->victory_current,
            'integral_total' => $item->integral_total,
            'code'=>1,
            'phone'=>$item->phone
        ];
    }

}