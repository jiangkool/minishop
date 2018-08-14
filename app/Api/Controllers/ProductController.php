<?php

namespace App\Api\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;
use App\Models\Product;
use App\Transformers\ProductShowTransformer;

class ProductController extends Controller
{
    use Helpers;

    public function __construct(){
    	$this->middleware(['auth:api'])->except('show');
    }

    public function show($id)
    {
    	return $this->response->item(Product::find($id),new ProductShowTransformer)->setStatusCode(201);
    }

    public function price(Request $request)
    {
    	
    }
}
