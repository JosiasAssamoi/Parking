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

    public function users(){

        return $this->belongsToMany('User')->withPivot('date','duree');
        // return $this->belongsTo('User');
    }


}
