<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class TokenMiddleware extends BaseMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //获取 token
        $token=\JWTAuth::getToken();

        try {
            //验证 token
            \JWTAuth::parseToken()->authenticate();
            //token 到期
        } catch (TokenExpiredException $e) {

            //刷新 token
            try {
                 $token = auth('api')->refresh();
                 $user = auth('api')->setToken($token)->User();
                 
            } catch (JWTException $e) {

                return response()->json(['msg'=>$e->getMessage()])->setStatusCode(402);
            }
            
        } catch(JWTException $e){

            return response()->json(['msg'=>$e->getMessage()])->setStatusCode(402);
        }

        $response = $next($request);

        //返回 token
        return $this->setAuthenticationHeader($response, $token);
    }


}
