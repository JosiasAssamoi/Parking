<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{

	protected $fillable= ['dispo'];
	public $timestamps = false;

	 /**
    * les utilisateurs qui ont possedé cette place
    */

    public function reservations(){
    	// une place a plusieurs reservations
        return $this->hasMany('\App\Reservation');
    }


}
