<?php

namespace App\Api\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\MiniappRequest;
use Dingo\Api\Routing\Helpers;
use App\Models\User;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use App\Transformers\BannerTransformer;
use App\Transformers\CategoryTransformer;
use App\Transformers\ProductTransformer;

class HomeController extends Controller
{
	use Helpers;

    public function __construct(){
    	$this->middleware(['token'])->except('login','shopName','banner','category','goodsList');
    }

    public function login(MiniappRequest $request)
    {
    	$code = $request->code;
    	$miniProgram = \EasyWeChat::miniProgram(); 
    	$data=$miniProgram->auth->session($code);
        $user = User::firstOrCreate([
          'weixin_openid' => $data['openid']
        ]);
        $attributes['weixin_session_key'] = $data['session_key'];
        $user->update($attributes);
    	$token = auth('api')->fromUser($user);
        
            return $this->response->array([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => \Auth::guard('api')->factory()->getTTL() * 60,
            'user_info' =>collect($user)->except(['weixin_openid', 'weixin_session_key', 'session_id'])->all()
            ]);

    	   
    }

    protected function respondWithToken($token)
    {
        return $this->response->array([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => \Auth::guard('api')->factory()->getTTL() * 60
        ]);
    }

    public function shopName()
    {
        return $this->response->array(['mallName'=>\Config::get('app.name', 'default'),'code'=>0]);
    }

    public function banner()
    {
        $data=Banner::where('status',1)->get();
        return $this->response->collection($data, new BannerTransformer)->setStatusCode(201);
    }

    public function category()
    {
        return $this->response->collection(Category::where('parent_id',0)->active()->sort()->get(),new CategoryTransformer)->setStatusCode(201);
    }

    public function goodsList($id)
    {
        return $this->response->collection(Product::active()->get(),new ProductTransformer)->setStatusCode(201);
    }



}
