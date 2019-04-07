<?php

namespace App\Http\Middleware;

use Closure;

class CheckCookie
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
        //检测是否登录
        if(isset(_COOKIE['id']) && isset($_COOKIE['token'])){
            $key='token:u:'.$_COOKIE['id'];
            $token=Redis::hGet($key,'web');
            if($_COOKIE['token']==$token){
                $request->attributes->add('is_login'=>1);
            }else{
                $request->attributes->add('is_login'=>0);
            }
        }
        return $next($request);
    }
}
