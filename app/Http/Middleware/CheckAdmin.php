<?php

namespace App\Http\Middleware;

use Closure;

class CheckAdmin
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

      //si l'id de la requete(nom du parametre de la route donc la c'est user) est différent de l'id de l'user en ligne on le redirige
          if ($request->user()){
              if(!$request->user()->isAdmin() ) {
                return back();
            }
    }

         return $next($request);
    }
}
