<?php

use Carbon\Carbon;


	setlocale(LC_TIME, 'fr_FR');

	Carbon::setLocale('fr');



	if(!function_exists('datesToFrench')){
		function datesToFrench($place){
	        $place = new Carbon($place);
	        $place=$place->formatLocalized('%d %B %Y');
	        return $place;
		}
	}


	if(!function_exists('FinishDate')){
		function FinishDate($place,$duree){
	     $place = new Carbon($place);
	     $place = $place->addDays($duree);
	        return datesToFrench($place);
		}
	}