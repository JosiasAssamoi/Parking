<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class QueueController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('is_admin');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::whereNotNull('rang')->get();
        return view('/admin/edit-queue',compact('users'));
    }

   
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //si le select choix_rang a ete modifié on update les rangs
       if($request->choix_rang){
        User::UpdateRanks($request->choix_rang);
        }

        $users=User::whereNotNull('rang')->get();
        return view('/admin/edit-queue',compact('users'));
    }

}
