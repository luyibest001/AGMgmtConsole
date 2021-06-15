<?php

namespace App\Http\Middleware;

use JWTAuth;
use Exception;
use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddlewareWeb extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return redirect()->route('login-page');
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return redirect()->route('login-page');
            }else{
                return redirect()->route('login-page');
            }
        }
        return $next($request);
    }
}
