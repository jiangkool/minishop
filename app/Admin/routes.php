<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');

    $router->resource('banner', BannerController::class);
    $router->resource('user', UserController::class);
    $router->resource('coupon', CouponsController::class);
    $router->resource('category', CategoryController::class);
    $router->post('banner/operate/{banner}', 'BannerController@operate');

    $router->resource('product', ProductController::class);
    $router->post('product/operate/{product}', 'ProductController@operate');

    $router->resource('order', OrderController::class);
    $router->resource('apply', ApplyController::class);
    $router->post('apply/operate/{apply}', 'ApplyController@operate');

    $router->resource('evaluates', EvaluateController::class);

    $router->resource('exchanges', ExchangeController::class);

    $router->get('payments', 'PaymentController@index');

    $router->get('recommend', 'RecommendController@index');

});
