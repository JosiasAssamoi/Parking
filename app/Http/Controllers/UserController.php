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
use App\PlaceRequest;

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
        $AlreadyRequested=PlaceRequest::where('user_id',Auth::user()->id)->where('etat',0)->first();
        return view('index',compact('AlreadyRequested'));
    }


    /**
     * Display a resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
       // On recupere les places que l'utilisateur possede en ce moment
      $current_places=$user->getCurrrentPlaces($user->places);

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
    $AlreadyRequested='';

    // on cherche une place dispo de maniere aleatoire
   $place=Place::where('dispo',1)->orderByRaw("RAND()")->first();
   //si on n'en trouve pas liste d'attente
    if(empty($place)){
        // Check si il n'a pas deja une demande en attente
        $AlreadyRequested=PlaceRequest::where('user_id',$user->id)->where('etat',0)->first();
       if (!$AlreadyRequested){
            $max_rang= PlaceRequest::max('rang');
            PlaceRequest::create(['user_id'=>$user->id, 'rang'=> empty($max_rang) ? 1 : ($max_rang+1) ]);
            $request_response['msg']="Votre demande a été soumise, vous serez informé lors de son traitement";
            $request_response['status']='success';
        }else{
            $request_response['msg']='Vous avez deja une demande en attente effectuée le '.dates_to_french($AlreadyRequested->date_demande) ;
            $request_response['status']='danger';
        }
    }
    //si il n'a pas de place actuellement
    elseif(empty($user->getCurrrentPlaces($user->places))){

       //on attache la place a l'user dans la table pivot  
       $user->places()->attach($place->id);
       // mieux mais ne fonctionne pas . ..$place->refresh()
       $newplace=$user = \DB::table('place_user')->where('place_id', $place->id)->first();
       $request_response['msg']="la place n° : ".$newplace->place_id." vous a été attribué "."pour une durée de ".$newplace->duree." jours (plus de détails dans l'onglet voir mes places";
         $request_response['status']='success';
         $place->dispo=0;
         $place->save();
    }
    // c'est que des places sont dispo mais qu'il en a deja une en ce moment
    else{
        $request_response['msg']='Vous avez deja une place en ce moment attendez la fin de votre reservation avant de reiterer une demande' ;
        $request_response['status']='danger';

    }
         
    return response()->view('index',compact('user','request_response','AlreadyRequested'))->header("Refresh","5;url=/user");
   }

   public function delete_place(Place $place) {

    \DB::table('place_user')
    ->where('user_id', Auth::user()->id)
    ->where('place_id', $place->id)
    ->update(array('deleted_at' => \DB::raw('NOW()')));
    $user=Auth::user();
    $request_response['msg']='Vous venez de supprimer votre reservation !' ;
    $request_response['status']='success';
    return response()->view('index',compact('user','request_response'))->header("Refresh",'5;url=/user');
    }
}
