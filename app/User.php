<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract ;


class User extends Authenticatable  implements CanResetPasswordContract
{
    use Notifiable;
    use CanResetPassword;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','firstname', 'email','adresse','city','postal_code', 'password','rang'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','rules'
    ];

    protected $current_places=[];

    /**
    * les places qui appartiennent à un user
    */

    public function places(){

        return $this->belongsToMany('\App\Place')->withPivot('date','duree','deleted_at');
    }

    // un User peut avoir plusieurs reservations
    public function reservations(){
        return $this->HasMany('\App\Reservation');
    }




     /**
     * Les places actuelles de l'user
     *
     * @var $places
     * @return array
     */

// A REFAIRE
/*
     public function getCurrrentPlaces($places){
        foreach($places as $place)
        {
            //si la place n'est pas supprimée deletedat serna null
            if(empty($place->pivot->deleted_at)){
                // calcul de la date de fin de reservation de la place
                $finishdate = strtotime($place->pivot->date . '+'.$place->pivot->duree." days");
                // si le timestamps actuel est inferrieur a celui de la date de fin
                if(time() < $finishdate){
                    $this->current_places[]=$place;}
                }
            }

        return $this->current_places;

    }*/

}
