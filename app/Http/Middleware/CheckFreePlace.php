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
       zdd($request->user()->rang);
            // on check si il y a une place dispo pour lui
            if($place = $this->place_available()){
                // on lui attribue la place

                $this->attach_place($place, $request->user());
                // On recupere cette nouvelle place qui est donc la derniere de cette user
                $newplace=$request->user()->reservations()->where('place_id', $place->id)->orderBy('date_debut','desc')->first();
                $request_response['msg']="Bonne nouvelle ! La place n°".$newplace->place_id." s'etant libérée, elle vous a été attribuée "
                .$newplace->date_fin ;
                $request_response['status']='success';
                Session::flash('request_response', $request_response);
                //to do decrémentation du rang de  chaque autre user
                $this->decrements_ranks();

            }

        }
        return $next($request);
    }

   
    private function place_available(){

        // on cherche une place dispo de maniere aleatoire
        return Place::FreePlace()->first();
    }

    private function attach_place($place, $user){

        //on attache a l'user la place  dans la table reservations
        $user->reservations()->create(['place_id'=>$place->id]);
        //on enleve l'user du rang 
        $user->rang=null; 
        $user->save();
    }

    private function decrements_ranks(){

        foreach (User::whereNotNull('rang')->get() as $user ) {
            if($user->rang!=1){
                $user->rang= $user->rang-1 ;  
                $user->save();
            }
        }
    }
}
