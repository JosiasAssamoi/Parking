<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Http\Requests\ChangePasswordFormRequest;
use App\Http\Requests\EditUserFormRequest;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Place;
use App\Reservation;

class UserController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */

     public function __construct()
    {
        setlocale(LC_TIME, 'fr_FR');
        $this->middleware('auth');
        $this->middleware('user_safe');
    }


    /**
     * Display a user menu.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        // renvoi la valeur du rang de l'user actif
        $user= Auth::user();
        $AlreadyRequested=$user->rang;
        // places actuelles
        $current_places=$user->getCurrrentPlaces(Reservation::where('user_id',$user->id)->where('is_cancelled',false)->get());
        // ce serait interessant de lancer un evenement a chaque fois que la page est raffraichie pour les user en attente
        return view('index',compact('AlreadyRequested','current_places'));
    }


    /**
     * Display a resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
       // On recupere les places que l'utilisateur possede en ce moment
      $current_places=$user->getCurrrentPlaces(Reservation::where('user_id',$user->id)->where('is_cancelled',false)->get());

      return view('show',compact('user','current_places'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {

        return view('edit-profil');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    // Le route implicit binding recupere automatiquement le bon user
    // Si le EditFormRequest passe c'est que les infos sont valides
    public function update(EditUserFormRequest $request,User $user)
    {
        $user->update($request->all());

        return back()->with('success','Vos changement ont bien eté pris en compte');
    }


     public function change_pass_create (User $user) {

        return view('change-pass');
   }


   public function change_pass(User $user, ChangePasswordFormRequest $request) {

    //si le hash check ne match pas on return une erreur
    if (!(Hash::check($request->password, $user->password)))
    {

    return back()->with('error','Saisie incorrecte du mot de passe actuel.');

    }

     $user->fill([
     'password' => Hash::make($request->newpassword)
        ])->save();

      return back()->with('success','Mot de passe changé avec succès');


   }


   // du gros pathé qui fonctionne mais a refactorer !!
   public function place_request(User $user){
       $request_response=[];
       $AlreadyRequested=$user->rang;
       $current_places=$user->getCurrrentPlaces(Reservation::where('user_id',$user->id)->where('is_cancelled',false)->get());


        //si il a deja une place en ce moment error
        if(!empty($current_places)){
            $request_response['msg']='Vous avez deja une place en ce moment attendez la fin de votre reservation avant de reiterer une demande' ;
            $request_response['status']='danger';
        }
        //il n'a pas de place
        else{
            // on cherche une place dispo de maniere aleatoire
            $place=Place::where('dispo',1)->orderByRaw("RAND()")->first();
             // On regarde si il a deja fait une demande
            if(!empty($AlreadyRequested)){
                $request_response['msg']='Vous avez deja  effectuée une demande, elle sera traitée des qu\'une place se liberera' ;
                $request_response['status']='danger';
            }
            // il n'a pas fait de demande
            // si il y a deja une queue et que l'user n'y est pas encore il doit prendre la derniere place OU si il n' y a pas de place dispo
            elseif( User::max('rang')!=null || empty($place) ){
                 $user->rang= empty(User::max('rang')) ? 1 : (User::max('rang')+1) ;
                 $user->save();
                 $request_response['msg']="Votre demande a été soumise, vous serez informé lors de son traitement";
                 $request_response['status']='success';
                 $AlreadyRequested=$user->rang;
            }
            // il n'a pas de place && personne n'est avant lui && et il n'a pas deja une demande en attente  && une place est dispo
            else{
                //on attache a l'user la place  dans la table reservations
                $user->reservations()->create(['place_id'=>$place->id]);
                // on recupe cette nouvelle place 
                $newplace=$user->reservations()->where('place_id', $place->id)->orderBy('date_debut','desc')->first();
                $current_places=$newplace;
                $request_response['msg']="la place n° : ".$newplace->place_id." vous a été attribué "."pour une durée de ".$newplace->duree." jours (plus de détails dans l'onglet => \"Voir mes places\" ";
                $request_response['status']='success';
                // on enleve la disponibilité de la place
                $place->dispo=0;
                $place->save();    
            }
        }

        //  return response()->view('index',compact('user','request_response','AlreadyRequested'))->header("Refresh","5;url=/user");
        return view('index',compact('user','request_response','AlreadyRequested','current_places'));
  }





   public function delete_place(Place $place) {
     //suppression logique dans la table reservation
    $user=Auth::user();
  //  dump($user->id);
    //dd($place->id);
    $user->reservations()->where('place_id',$place->id)->update(['is_cancelled'=> true]);

    // set dispo de la place
    $place->dispo=1;
    $place->save();

    // response
    $request_response['msg']='Vous venez de supprimer votre reservation !' ;
    $request_response['status']='success';

    $user=Auth::user();

  //  return response()->view('index',compact('user','request_response'))->header("Refresh",'5;url=/user');
    return view('index',compact('user','request_response'));
    }
}
