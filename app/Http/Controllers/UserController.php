<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Http\Requests\EditUserFormRequest;
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
        $this->middleware('check_free_place')->except(['index','destroy']);
    }


    /**
     * Display a user menu for admin.
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


     /**
     * Display a menu for simple user.
     *
     * @return \Illuminate\Http\Response
     */

    public function home()
    {
        return view('user-index');
    }


    /**
     * Display a resource for simple user.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        if($user->can('user_access', $user)){
             // On recupere les places que l'utilisateur possede en ce moment
             $current_place=$user->getCurrrentPlace();
             $all_places= $user->MyHistoric();
             return view('user-show',compact('user','current_place','all_places'));    
        }
        return back();
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {   
        if($user->can('user_access', $user)){
            return view('edit-profil');
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

    // Si le EditFormRequest passe c'est que les infos sont valides
    public function update(EditUserFormRequest $request,User $user)
    {
        $user->update($request->all());
        return back()->with('success','Vos changement ont bien eté pris en compte');
    }


    /**
     * Delete the specified resource in storage.
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user){

        if(Auth::user()->can('only_admin',Auth::user())){
            // -1 = ko
            $user->tovalid= -1 ;
            $user->reservations()->delete();
            if($user->isInQueue()){
                $user->leave_request();
            }
            $user->save();
            return back()->with('success','L\'utilisateur '.$user->name.' à bien été supprimé');
        }
        return back();
    }

        public function booking_cancel(User $user){

        $user->leave_request();
        return back()->with('warning','Votre demande de place a bien été annulée, vous avez perdu votre rang');
    }



}
