@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">Tableau de bord</div>
                    @if(Session::has('success'))
                      <div class ="alert alert-success text-center">
                      {{Session::get('success')}}</div>
                      @elseif(Session::has('warning'))
                        <div class ="alert alert-warning text-center">
                        {{Session::get('warning')}}
                        </div>
                    @endif
                    <div class="wrapper text-center">



                   <a href="{{route('user.show',Auth::user())}}" class="btn btn-outline-secondary my-1" role="button">Voir mes places</a>
                   <a href="{{ route('user.edit',['user'=> Auth::user()] ) }}" class="btn btn-outline-secondary my-1" role="button">Editer votre profil</a>
                   <hr/>

               

                   @can('seeHisRank',App\User::Class)                
                      <form action ="{{route('user.cancel',Auth::user())}}" method=POST>
                        <p  class="alert alert-info" >Vous avez effectué une demande en attente de validation et vous êtes au rang n° {{Auth::user()->rang}}
                        @csrf
                        <input type="submit" class="btn  btn-sm btn-secondary ml-2"  onclick="return confirm('Êtes-vous sûr de vouloir annuler cette demande reservation ? (Vous perdrez votre rang)');" value ="Annuler"></input> </p>
                      </form>

                      @elsecannot('seeHisRank',App\User::Class)
                      <p>Vous n'avez aucune demande de reservation en attente. </p>
                   @endcan


                   @can('request_booking',App\User::class)
                     <form action ="{{route('booking.store')}}" method=POST>
                        @csrf
                        <input type="submit" class="btn btn-outline-secondary my-1"  onclick="return confirm('En validant cette demande une place vous sera attribué si nous en trouvons une de disponible, le cas échéant vous serez placé en liste d\'attente ');" value="Reserver une place"/>
                      </form>
                  @endcan
               </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
