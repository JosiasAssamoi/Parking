<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Http\Requests\ChangePasswordFormRequest;
use App\Http\Requests\EditUserFormRequest;
use Illuminate\Support\Facades\Hash;
use App\User;

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
}
