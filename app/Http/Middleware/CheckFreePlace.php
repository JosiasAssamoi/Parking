<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use App\Place;
Use Session;

class CheckFreePlace
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


        if($request->user()->rang){
            User::trigger_assign_place();
        }
              return $next($request);
    }

}
