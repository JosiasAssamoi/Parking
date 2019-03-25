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

    public function leave_request(){
        //les users qui ont un rang superieur a l'utilisateur qui annule
        User::where('rang','>',$this->rang)->decrement('rang');
        $this->rang=null;
        $this->save();
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
            if($new_rang > $user->rang)
            self::decrement_users($user->rang, $new_rang);
            else self::increment_users($user->rang, $new_rang);
            $user->rang=$new_rang;
            $user->save();
        }
    }

    private static function decrement_users($user_rang, $new_rang){
        User::where('rang','>',$user_rang)->where('rang','<=',$new_rang)->decrement('rang');
    }

    private static function increment_users($user_rang, $new_rang){
        User::where('rang','<',$user_rang)->where('rang','>=',$new_rang)->increment('rang');
    }




    public function check_free_place(){

      if($place = $this->place_available()){
          $this->attach_place($place, $this);
          // On recupere cette nouvelle place qui est donc la derniere de cette user
          $newplace=$this->reservations()->where('place_id', $place->id)->orderBy('date_debut','desc')->first();
          $request_response['msg']="Bonne nouvelle ! La place n°".$newplace->place_id." s'etant libérée, elle vous a été attribuée jusqu'au "
          .dates_to_french($newplace->date_fin) ;
          $request_response['status']='success';
          Session::flash('request_response', $request_response);
          //to do decrémentation du rang de  chaque autre user
          $this->decrements_ranks();
      }

    }


        private function place_available(){

            // on cherche une place dispo de maniere aleatoire
            return Place::FreePlace()->first();
        }

        private function attach_place($place, $user){

            //on attache a l'user la place  dans la table reservations
            $user->reservations()->create(['place_id'=>$place->id]);
            //on enleve l'user du rang
            $user->rang=null;
            $user->save();
        }

        // decrement tout les users quand une place est attribuée
        private function decrements_ranks(){

            foreach (User::whereNotNull('rang')->get() as $user ) {
                if($user->rang!=1){
                    $user->rang= $user->rang-1 ;
                    $user->save();
                }
            }
        }

}
