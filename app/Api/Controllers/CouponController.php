<?php

namespace App\Api\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;
use App\Models\Coupon;

class CouponController extends Controller
{
    use Helpers;

    public function __construct()
    {
    	$this->middleware(['token']);
    }

    public function index(Request $request)
    {
    	//
    }
}
