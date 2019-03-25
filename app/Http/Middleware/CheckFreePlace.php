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

        // si l'user a un rang (donc en file d'attente)  && et que ce rang est le minimum trouve de la Bdd
        if(isset($request->user()->rang) && !empty($request->user()->rang) && User::min('rang')==$request->user()->rang){
          $request->user()->check_free_place();
            }
              return $next($request);
    }

}
