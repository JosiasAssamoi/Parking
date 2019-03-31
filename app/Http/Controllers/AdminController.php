<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use View;
use App\User;
use Session;
use Place;
use Hash;
use Illuminate\Support\Facades\Input;


class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('is_admin');
    }

    /**
     * Show the admin application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function admin_index()
    {
        return view('/admin/home');
    }

    public function assign_place(Request $request,User $user){
        //TO DO NOTIFIER L'UTILISATEUR
        $user->reservations()->create(['place_id'=>$request->choix_place]);
        if(!empty($user->rang))
            $user->leave_request();
        return back()->with('success','la place a bien été attribuée');
    }

    public function reset_pass(User $user){
      $user->password= Hash::make('1234');
      $user->save();
      return back()->with('success','mot de passe de l\'utilisateur '.$user->name." ".$user->firstname.' a bien été réinitialisé');
    }

}
