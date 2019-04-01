<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Place;
use App\Reservation;
use Session ;
use Auth ;


class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       if(Auth::user()->can('only_admin',Auth::user())){
            $users=User::has('reservations')->get();
            return view('/admin/show-res',compact('users'));
       }
       return back();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $user=Auth::user();
        if(empty($user->getCurrrentPlace())){
          $place=$user->assign_free_place();
        if(empty($place))
            Session::flash('warning','Votre demande de place n\'a pu aboutir, Veuillez re essayer ultérieurmeent');
        else
        Reservation::sendNewBookingResponse($place);
        }
       //  return response()->view('index',compact('user','request_response','AlreadyRequested'))->header("Refresh","5;url=/user");
        return back();
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservation $booking){

        $booking->date_fin=now();
        $booking->save();

        return back()->with('success','reservation supprimée');
    }

}
