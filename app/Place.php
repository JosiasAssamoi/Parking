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
    	// si le champ deleted_at est null c'est qu'il n'ya  pas eu de suppression
        return $this->belongsToMany('User')->withPivot('date','duree','deleted_at');
        // return $this->belongsTo('User');
    }


}
