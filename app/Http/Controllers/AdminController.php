<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

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
        return 'a faire toutes les demandes d\'inscriptions' ;
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
