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


    public static function assign_free_place($user){

      if($place = self::place_available()){
          self::attach_place($place, $user);
          // On recupere cette nouvelle place qui est donc la derniere de cette user
          $newplace=$user->reservations()->where('place_id', $place->id)->orderBy('date_debut','desc')->first();
          $request_response['msg']="Bonne nouvelle ! La place n°".$newplace->place_id." etant libre, elle vous a été attribuée jusqu'au "
          .dates_to_french($newplace->date_fin);
          $request_response['status']='success';
          Session::flash('request_response', $request_response);
          //to do decrémentation du rang de  chaque autre user
          User::decrements_all_ranks();
      }

    }


        private static function place_available(){

            // on cherche une place dispo de maniere aleatoire
            return self::FreePlace()->first();
        }

        private static function attach_place($place, $user){

            //on attache a l'user la place  dans la table reservations
            $user->reservations()->create(['place_id'=>$place->id]);
            //on enleve l'user du rang
            $user->rang=null;
            $user->save();
        }



}
