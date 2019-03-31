<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Place;
class PlaceController extends Controller
{

    public function __construct()
    {
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
        $places=Place::paginate(5);
        return view('admin/place-index',compact('places'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
       Place::create(['dispo'=>'1']);
       return back()->with('success','La place a bien été crée');
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Place $place)
    {
     
        $place->dispo = !$place->dispo;
        $place->save();

        return back()->with('success','La place a bien eté modifiée');
    }

}
