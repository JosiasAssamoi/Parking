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


        if(User::min('rang')==$request->user()->rang){
          Place::assign_free_place($request->user());
            }
              return $next($request);
    }

}
