<?php

namespace App\Http\Middleware;

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
        $cur_user = Auth::user();
        if(!$cur_user || !$cur_user->is_admin){
          dd("Accés refusé");
        }

        return $next($request);
    }

}
