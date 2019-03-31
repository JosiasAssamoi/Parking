<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use App\User;
use Session;
class RegisteringController extends Controller
{
  
  public function __construct (){

    $this->middleware('auth');
    $this->middleware('is_admin');
  }
    public function index()
    {
          // recuperation de tout les users a valider pour actualiser la vue
        $users=User::where('tovalid',1)->get();
        //On peut utiliser la facade View pour renvoyer une vue
        return View::make('admin/register_requests',compact('users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(User $registering)
    {
        $registering->valid();
        Session::Flash('success','L\'utilisateur '.$registering->name." ".$registering->firstname.' a bien été validé !');
        return back();    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
