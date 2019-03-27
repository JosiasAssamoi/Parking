<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Session ;

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

		// retourne l'utilisateur sur la  place
		public function user(){

			$user=$this->reservations()->where('date_fin','>',now())->first() ;
			return $user->user_id;
		}

 	/**
    * Recupere une place libre dans la base donc qui n'a pas de reservation en cours 
    */

		public function scopeFreePlace(){
      
			return $this->where('dispo',1)->WhereDoesntHave('reservations', function ($query){
			$query->where('date_fin','>',now());
			}
		)->OrderByRaw('RAND()')->get();
		}




}
