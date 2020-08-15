<?php

namespace App\Http\Middleware;

use Closure;

class isCustomer
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
        if(auth()->check() && $request->user()->admin == 1){
            return redirect()->guest('adminHome');
        }
        return $next($request);
    }
}
