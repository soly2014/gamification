<?php

namespace Learncloud\Http\Middleware;

use Closure;
use Auth;

class IsAdmin
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
         if( Auth::user()->facebook_id != '991707657588627'){
            
            return redirect('/home/profile');
        }
          
        return $next($request);
    }
}
