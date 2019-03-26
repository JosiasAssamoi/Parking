<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract ;
use Session;


class User extends Authenticatable  implements CanResetPasswordContract
{
    use Notifiable;
    use CanResetPassword;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','firstname', 'email','adresse','city','postal_code', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','rules'
    ];


    // un User peut avoir plusieurs reservations
    public function reservations(){
        return $this->hasMany('\App\Reservation');
    }


    public function isAdmin(){

         return $this->rules=="admin";
    }


     /**
     * La place actuelle de l'user
     *
     * @var $places
     * @return Place
     */

     public function getCurrrentPlace(){

       return $this->reservations()->where('date_fin' ,'>',now())->first();

      }

       /**
     * L'historique d'un user
     * @return Collection de reservations
     */

    public function   MyHistoric(){

      return $this->reservations()->get();
    }

    /**
    * valide un utilisateur en attente
    */
    public function valid(){
        $this->tovalid=0;
        $this->save();
    }

    public static function UpdateRanks( $choix_rang){


        foreach ($choix_rang as $id => $new_rang) {

            $user=User::where('id',$id)->first();
            //ca veut dire que l'user perd en rang et on decremente les autres users qui sont entre le rang de l'utilisateur et son nouveau rang
            if($new_rang > $user->rang )
                $user->decrement_users($user->rang, $new_rang);
            elseif($new_rang==-1){
                $user->leave_request();
                continue;
            }
            else 
                $user->increment_users($user->rang, $new_rang);
            $user->rang=$new_rang;
            $user->save();
        }
    }

    private  function decrement_users($user_rang, $new_rang){

        User::where('rang','>',$user_rang)->where('rang','<=',$new_rang)->decrement('rang');
    }

    private  function increment_users($user_rang, $new_rang){
        User::where('rang','<',$user_rang)->where('rang','>=',$new_rang)->increment('rang');
    }


       public function leave_request(){
        //les users qui ont un rang superieur a l'utilisateur qui quitte son rang
        User::where('rang','>',$this->rang)->decrement('rang');
        $this->rang=null;
        $this->save();
    }



}
