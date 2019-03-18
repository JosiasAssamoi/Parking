<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Reservation;
use App\Place;
use Session;

class CheckEndResaListener
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

    // a tester
    public function handle(Login $event)
    {
        // pour chaque place non annulée
        if($resas=Reservation::where('user_id',$event->user->id)->where('is_cancelled',false)->get()){
            foreach ($resas as $resa) {
                $finishdate = strtotime($resa->date_debut . '+'.$resa->duree." days");
                // si le timestamps actuel est superieur a celui de la date de fin
                if(time() > $finishdate){
                    $resa->is_cancelled= true;
                    $resa->save();
                    $place=Place::where('id',$resa->place_id)->first();
                    // set dispo de la place
                    $place->dispo=1;
                    $place->save();

                    // response
                    $request_response['msg']='Votre reservation a pris fin le '.dates_to_french(date("m/d/Y h:i:s",$finishdate)) ;
                    $request_response['status']='warning';
                    Session::flash('request_response', $request_response);
                }
            }
        }
    }

    
}
