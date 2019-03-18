@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">Tableau de bord</div>

                    @if(isset($request_response) || $request_response=Session::get('request_response'))

                    <div class ="alert alert-{{$request_response['status']}} text-center">
                      {{$request_response['msg']}}
                    </div>

                    @endif
                    <div class="wrapper text-center">



                   <a href="{{route('user.show',Auth::user())}}" class="btn btn-outline-secondary my-1" role="button">Voir mes places</a>
                   <a href="{{ route('user.edit',['user'=> Auth::user()] ) }}" class="btn btn-outline-secondary my-1" role="button">Editer votre profil</a>
                   <hr/>

                   @if(empty($AlreadyRequested))


                      <p>Vous n'avez aucune demande de reservation en attente. </p>

                   @elseif(!isset($request_response))
                      <p  class="alert alert-info" >Vous avez une demande en attente de validation et vous êtes au rang n° {{Auth::user()->rang}} </p>

                   @endif
                    
                   @if(empty($AlreadyRequested) && empty($current_places))
                  

                     <form action ="{{route('user.request',Auth::user())}}" method=POST>
                        @csrf
                        <input type="submit" class="btn btn-outline-secondary my-1"  onclick="return confirm('En validant cette demande une place vous sera attribué si nous en trouvons une de disponible, le cas échéant vous serez placé en liste d\'attente ');" value="Reserver une place"/>
                      </form>
                  @endif
               </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
