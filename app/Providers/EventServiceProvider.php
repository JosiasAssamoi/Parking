<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Reservation;
use Carbon\Carbon;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
       /* 'Illuminate\Auth\Events\Login' => [
            'App\Listeners\PlaceRequestListener',
        ],*/


    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        $this->setdatefin();
   }


    private function setdatefin()
    {
      Reservation::created(function($reservation){
        $reservation->refresh();
        $date_fin= new Carbon ($reservation->date_fin);
        $date_fin->addDays(2);
        $reservation->date_fin= $date_fin;
        $reservation->save();
    });
    }
}
