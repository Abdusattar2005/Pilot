<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Exceptions\CustomException;

class UserBan
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
         
        if(isset(auth()->user()->status_subscription)){
            if((int) auth()->user()->status_subscription === 1) {
                //auth()->invalidate(true); // не удаляем токен
                CustomException(1018);      
            }
        }
        return $next($request);
    }
}
