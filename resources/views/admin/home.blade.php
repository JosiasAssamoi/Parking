@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">Tableau de bord (Admin) </div>

                    @if(isset($request_response) || $request_response=Session::get('request_response'))

                    <div class ="alert alert-{{$request_response['status']}} text-center">
                      {{$request_response['msg']}}
                    </div>

                    @endif
                    <div class="wrapper text-center">



                   <a href="{{route('registering.index')}}"class="btn btn-outline-secondary my-1"role="button">Editer demandes d'inscriptions</a>
                   <a href="{{ route('place.index') }}" class="btn btn-outline-secondary my-1" role="button">Editer les places</a>
                   <a href="{{ route('user.index') }}" class="btn btn-outline-secondary my-1" role="button">Editer les utilisateurs</a>
                   <a href="{{ route('queue.index') }}" class="btn btn-outline-secondary my-1" role="button">Editer la liste d'attente </a>
                   <a href="{{ route('booking.index') }}" class="btn btn-outline-secondary my-1" role="button">Voir historique des reservations </a>
                   <hr/>
               </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection