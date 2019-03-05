<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $this->middleware('auth');
        $this->middleware('user_safe');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('index');
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
    public function update(EditUserFormRequest $request,User $user)
    {
        $user->update($request->all());

        return back()->with('success','Vos changement ont bien eté pris en compte');
    }


     public function change_pass_create ($user) {

     return view('change-pass');
   }


   public function change_pass($user, ChangePasswordFormRequest $request) {

    if (!(Hash::check($request->password, Auth::user()->password)))
    {

    return back()->with('error','Mot de passes différents');

    }

     $request->user()->fill([
            'password' => Hash::make($request->newpassword)
        ])->save();

      return back()->with('success','Mot de passe changé avec succès');
 

   }
}
