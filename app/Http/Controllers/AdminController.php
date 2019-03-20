<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use View;
use App\User;


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
       //Pour les policies
    //  $this->authorize('admin_index',Auth::user());

        return view('/admin/home');
    }

      public function edit_register_requests()
    {
       $users=User::where('tovalid',1)->get();
        //On peut utiliser la facade view pour renvoyer une vue
        return View::make('admin/register_requests',compact('users'));
    }

      public function edit_queue()
    {
        return 'edition de la liste dattente' ;
    }

     public function edit_users()
    {
        return 'edition des users' ;
    }
      public function show_res()
    {
        return 'historique des reservations' ;
    }
}
