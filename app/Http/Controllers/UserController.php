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
        $this->middleware('check_free_place')->except(['index']);
    }


    /**
     * Display a user menu.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $this->authorize('only_admin',Auth::user());
        $places=Place::FreePlace();
        $users=User::where('tovalid',0)->where('rules','utilisateur')->get();
        return view('admin/edit-users',compact('users','places'));
    }


    public function home()
    {
        // renvoi la valeur du rang de l'user actif
        $user= Auth::user();
        $AlreadyRequested=$user->rang;
        // places actuelles
        $current_place=$user->getCurrrentPlace();



        // ce serait interessant de lancer un evenement a chaque fois que la page est raffraichie pour les user en attente
        return view('index',compact('AlreadyRequested','current_place'));
    }



    /**
     * Display a resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
       // On recupere les places que l'utilisateur possede en ce moment
      $current_place=$user->getCurrrentPlace();
      $all_places= $user->MyHistoric();
      $AlreadyRequested=$user->rang;



      return view('show',compact('user','AlreadyRequested','current_place','all_places'));
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
       $current_place=$user->getCurrrentPlace();


        //si il a deja une place en ce moment error
        if(!empty($current_place)){
            $request_response['msg']='Vous avez deja une place en ce moment attendez la fin de votre reservation avant de reiterer une demande' ;
            $request_response['status']='danger';
        }
        //il n'a pas de place
        else{
            // on cherche une place dispo de maniere aleatoire
            $place=Place::FreePlace()->first();

          //$place=Place::FreePlaces();
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
                $current_place=$user->reservations()->where('place_id', $place->id)->orderBy('date_debut','desc')->first();

                $request_response['msg']="la place n° : ".$current_place->place_id." vous a été attribué "."jusqu'au "
                .dates_to_french($current_place->date_fin);
                $request_response['status']='success';
            }
        }

        //  return response()->view('index',compact('user','request_response','AlreadyRequested'))->header("Refresh","5;url=/user");
        return view('index',compact('user','request_response','AlreadyRequested','current_place'));
  }





   public function delete_place(Place $place) {
     //suppression logique dans la table reservation


    $user=Auth::user();

    if($user->isAdmin())
    {
      $user=User::where('id',$place->user())->first();

      $user->reservations()->where('place_id',$place->id)->update(['date_fin'=>now()]);
      return back()->with('success','reservation supprimée');
    }
    else{
    // quand on delete une place on set la date de fin a aujourd'hui
    $user->reservations()->where('place_id',$place->id)->update(['date_fin'=>now()]);
    // response
    $request_response['msg']='Vous venez de supprimer votre reservation !' ;
    $request_response['status']='success';
    }



  //  return response()->view('index',compact('user','request_response'))->header("Refresh",'5;url=/user');
    return view('index',compact('user','request_response'));
    }


    public function booking_cancel(User $user){

        $user->leave_request();

        return back()->with('warning','Votre demande de place a bien été annulée, vous avez perdu votre rang');


    }
}
