<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ChangePasswordFormRequest;
use App\User;

class UserPasswordController extends Controller
{
   

      public function __construct()
    {
        $this->middleware('auth');
       // $this->middleware('user_safe');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $userchangepass)

    {
        if($userchangepass->can('user_access', $userchangepass)){
            return view('change-pass');
        }
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(User $userchangepass, ChangePasswordFormRequest $request)
    {
    //si le hash check ne match pas on return une erreur
    if (!(Hash::check($request->password, $userchangepass->password)))
    {
        return back()->with('error','Saisie incorrecte du mot de passe actuel.');
    }

     $userchangepass->fill([
     'password' => Hash::make($request->newpassword)
        ])->save();

      return back()->with('success','Mot de passe changé avec succès');
        
    }
}
