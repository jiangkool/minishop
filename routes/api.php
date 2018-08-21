<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
		'namespace' => 'App\Api\Controllers'
	],function ($api) {

		$api->get('getShopName','HomeController@shopName');
		$api->post('auth/loginByWechat','HomeController@login');
		$api->get('banner','HomeController@banner');
		$api->get('categories','HomeController@category');

		$api->get('goods/list/{cid}','HomeController@goodsList');
		$api->get('goods/show/{id}','ProductController@show');
		$api->post('good/price','ProductController@show');
		$api->post('good/info','ProductController@info');

		$api->post('order','OrderController@index');
		$api->get('orderStatus','OrderController@orderStatus');
		$api->get('order','OrderController@list');
		$api->delete('order','OrderController@destory');

		$api->get('user/coupon/{id}','UserController@coupon');
		$api->post('user/login','UserController@login');

		$api->get('address','UserController@addresses');
		$api->post('setAddress','UserController@setDefaultAddress');
		$api->post('address','UserController@addressStore');
		$api->get('addressDetails','UserController@addressDetails');
		$api->delete('address','UserController@addressDestroy');
		$api->put('address','UserController@addressStore');

		$api->post('pay','OrderController@pay');
});