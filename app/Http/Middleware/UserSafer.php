<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;

class UserSafer
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
        //si l'id de la requete est différent de l'id de l'user en ligne on le redirige
          if ($request->user){
           // dd($request->user);
              if($request->user->id != Auth::id()) {
                return back();
            }
    }

         return $next($request);

    }
}
