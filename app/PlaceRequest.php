<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlaceRequest extends Model
{
     protected $fillable = ['etat','rang'];
  public $timestamps = false;

    /**
    * l'user de la demande
    */

    public function user(){
        return $this->belongsTo('User');
    }

}
