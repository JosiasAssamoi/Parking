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
        'name','firstname', 'email','adresse','city','postal_code', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','rules'
    ];





    // un User peut avoir plusieurs reservations
    public function reservations(){
        return $this->hasMany('\App\Reservation');
    }




     /**
     * Les places actuelles de l'user
     *
     * @var $places
     * @return array
     */


//  A ADMIRER

     public function getCurrrentPlace(){

       return $this->reservations()->where('date_fin' ,'>',now())->first();

      }



      /* {
                // calcul de la date de fin de reservation de la place
                $finishdate = strtotime($place->date_debut . '+'.$place->duree." days");
                // si le timestamps actuel est inferieur a celui de la date de fin
                if(time() < $finishdate){
                    $this->current_place[]=$place;}
            }

        return $this->current_place;

    }*/

}
