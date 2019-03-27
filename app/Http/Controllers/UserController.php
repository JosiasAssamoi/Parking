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
use Session;

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
        return view('index');
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


      return view('show',compact('user','current_place','all_places'));
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


// TO DO BOOKING CONTROLER

   public function place_request(User $user){

        if(empty($user->getCurrrentPlace())){
        $place=$user->assign_free_place(); 
        if(empty($place))
            Session::flash('warning','Votre demande de place n\'a pu aboutir, Veuillez re essayer ultérieurmeent'); 
        else
        Reservation::sendNewBookingResponse($place);
        }

        
            
        //  return response()->view('index',compact('user','request_response','AlreadyRequested'))->header("Refresh","5;url=/user");
        return back();
  }




   public function delete_booking(Place $place) {
     //suppression logique dans la table reservation
        $user=Auth::user();
        
        if($user->isAdmin())
        {
              $user=User::where('id',$place->user())->first();
              $user->reservations()->where('place_id',$place->id)->update(['date_fin'=>now()]);
        }
        // quand on delete une place on set la date de fin a aujourd'hui
        $user->reservations()->where('place_id',$place->id)->update(['date_fin'=>now()]);


         return back()->with('success','reservation supprimée');
    }


    public function booking_cancel(User $user){

        $user->leave_request();
        return back()->with('warning','Votre demande de place a bien été annulée, vous avez perdu votre rang');
    }


    public function destroy(User $user){
      
        $this->authorize('only_admin',Auth::user());
        // -1 = ko
        $user->tovalid= -1 ;
        $user->save();

        return back()->with('success','user supprimé');
    }



}
