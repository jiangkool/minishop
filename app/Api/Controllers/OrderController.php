<?php

namespace App\Api\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;
use App\Models\Order;

class OrderController extends Controller
{
    use Helpers;

    public function __construct(){
    	$this->middleware(['auth:api']);
    }

    public function store(Request $request)
    {
    	
    }


}
