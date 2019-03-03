<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email','adresse','city','postal_code', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','rules'
    ];

    /**
    * les places qui appartiennent à un user
    */

    public function places(){

        return $this->belongsToMany('\App\Place')->withPivot('date','duree');
    }


    /**
    * les demandes d'un user
    */

    public function place_requests(){

        return $this->hasMany('\App\PlaceRequest');
    }




}
