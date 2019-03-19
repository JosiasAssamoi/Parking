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
     * La place actuelle de l'user
     *
     * @var $places
     * @return Place
     */

     public function getCurrrentPlace(){

       return $this->reservations()->where('date_fin' ,'>',now())->first();

      }

    public function   MyHistoric(){

      return $this->reservations()->get();
    }

}
