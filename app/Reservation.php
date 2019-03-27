<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Session;

class Reservation extends Model
{
    protected $fillable= ['user_id','place_id'];
    public $timestamps = false;

// une reservation concerne un user
    public function user(){
      return $this->belongsTo('\App\User');
    }
// une reservation concerne une place
    public function place(){

        return $this->belongsTo('\App\Place');
    }

       public static function sendNewBookingResponse($place)
        {
            // On recupere cette nouvelle place qui est donc la derniere de cette user
          $newBooking=Reservation::where('place_id', $place->id)->orderBy('date_debut','desc')->first();

          Session::flash('success', 'Bonne nouvelle ! La place n°'.$newBooking->place_id.' vous a été attribuée');
        }

  
}
