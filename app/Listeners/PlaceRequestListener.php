<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User; 
use App\Place;
use App\Reservation;  
use Session;
class PlaceRequestListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        // si l'user a un rang (donc en file d'attente)  && et que ce rang est le minimum trouve de la Bdd
        if(!empty($event->user->rang) && User::min('rang')==$event->user->rang){
            // on check si il y a une place dispo pour lui
            if($place = $this->place_available()){
                // on lui attribue la place

                $this->attach_place($place, $event->user);
                // On recupere cette nouvelle place qui est donc la derniere de cette user
                $newplace=$event->user->reservations()->where('place_id', $place->id)->orderBy('date_debut','desc')->first();
                $request_response['msg']="Bonne nouvelle ! La place n°".$newplace->place_id." s'etant libérée, elle vous a été attribuée "
                ."pour une durée de ".$newplace->duree." jours (plus de détails dans l'onglet -> \"Voir mes places\" ";
                $request_response['status']='success';
                Session::flash('request_response', $request_response);
                //to do decrémentation du rang de  chaque autre user
                $this->decrements_ranks();

            }

        }
    }

   
    private function place_available(){

      

        // on cherche une place dispo de maniere aleatoire
        return Place::where('dispo',1)->orderByRaw("RAND()")->first();
    }

    private function attach_place($place, $user){

        //on attache a l'user la place  dans la table reservations
        $user->reservations()->create(['place_id'=>$place->id]);

        // on enleve la disponibilité de la place
        $place->dispo=0;
        $place->save();
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
