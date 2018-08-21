<?php

namespace App\Api\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;
use App\Models\Product;
use App\Models\ProductItem;
use App\Transformers\ProductShowTransformer;
use App\Transformers\ProductItemTransformer;

class ProductController extends Controller
{
    use Helpers;

    public function __construct(){
    	$this->middleware(['token'])->except('show','info');
    }

    public function show($id)
    {
    	return $this->response->item(Product::find($id),new ProductShowTransformer)->setStatusCode(201);
    }

    public function info(Request $request)
    {
    	return $this->response->item(ProductItem::where('product_id',$request->goodsId)->where('id',$request->propertyChildId)->first(), new ProductItemTransformer)->setStatusCode(201);
    }
}
