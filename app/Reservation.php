<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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

  
}
