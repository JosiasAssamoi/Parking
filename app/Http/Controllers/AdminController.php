<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use View;
use App\User;
use Session;
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

      public function edit_register_requests(User $user=null)
    {
        // si on recoit un user en param c'est qu'un patch a ete effectué pour le valider
        if(!empty($user)){
            $user->valid();
            Session::Flash('success','L\'utilisateur '.$user->name." ".$user->firstname.' a bien été validé !');
        }
        // recuperation de tout les users a valider pour actualiser la vue
       $users=User::where('tovalid',1)->get();

        //On peut utiliser la facade View pour renvoyer une vue
        return View::make('admin/register_requests',compact('users'));
    }


      public function edit_queue()
    {
        $users=User::whereNotNull('rang')->get();
        return view('/admin/edit-queue',compact('users'));
    }

     public function valid_queue(Request $request)
    {
       //si le select choix_rang a ete modifié on update les rangs 
       if($request->choix_rang){
        User::UpdateRanks($request->choix_rang);
        }

        $users=User::whereNotNull('rang')->get();
        return view('/admin/edit-queue',compact('users'));
    }



     public function edit_users()
    {
        return 'edition des users' ;
    }
      public function show_res()
    {
        $users=User::has('reservations')->get();
       return view('/admin/show-res',compact('users'));
    }

}
