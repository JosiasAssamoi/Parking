<?php

	use Carbon\Carbon;

	setlocale(LC_TIME, 'fr_FR');
	Carbon::setLocale('fr');

	if(!function_exists('dates_to_french')){
		function dates_to_french($place){
	        $place = new Carbon($place);
	        $place=$place->formatLocalized('%d %B %Y');
	        return $place;
		}
	}


	if(!function_exists('finish_date')){
		function finish_date($place,$duree){
	     $place = new Carbon($place);
	     $place = $place->addDays($duree);
	        return dates_to_french($place);
		}
	}