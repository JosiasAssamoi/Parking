@extends('layouts/app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center mb-3"> Historique des reservations (Admin) </div>
                <div class="wrapper text-center">
                <ul class="list-group  ">
                @if(Session::has('success'))
                <div class ="alert alert-success text-center">
                     {{Session::get('success')}}
                </div>
                @endif
                @forelse($users as $user)
                 <li  class="list-group-item d-flexalign-items-center ">
                <span><b>{{ucfirst($user->name)." ".$user->firstname}}</b> a eu les places suivantes : </span>
                <ul>
                    @foreach($user->reservations as $reservation)
                    <li  class="list-group-item">la place n°{{$reservation->place_id}} du {{dates_to_french($reservation->date_debut)}} au 
                        {{dates_to_french($reservation->date_fin)}}</li>
                    @endforeach
                </ul>
                </li>
                <hr/>
                @empty
                Aucun utilisateur n'a eu de reservations pour le moment. 
                @endforelse
              </ul>
              </div>
               </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop
