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

 	/**
    * Recupere une place libre dans la base donc qui n'a jamais eu de reservations ou qui n'en a aucune en cours
    */

		public function scopeFreePlace(){
			// first ne marche pas sur ce type de requete
			return $this->doesntHave('reservations')->orWhereDoesntHave('reservations', function ($query){
			$query->where('date_fin','>',now());
			}
		)->OrderByRaw('RAND()')->get();
		}


}
