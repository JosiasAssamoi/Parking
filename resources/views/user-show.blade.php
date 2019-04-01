@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header text-center">Historique des places</div>
                  <div class="card-body">
                      <div class="wrapper">
                        @if(Session::has('success'))
                          <div class ="alert alert-success text-center">
                          {{Session::get('success')}}</div>
                        @endif
                          @if($user->reservations)
                            <ul class="list-group text-center ">
                          @endif
                    
                          @forelse($all_places as $place)
                            @if ($place != $current_place)
                              <li  class="list-group-item  ">Place n° {{$place->place_id}} du  {{dates_to_french($place->date_debut)}} au
                                    {{dates_to_french($place->date_fin)}}
                                   <p class ="text-danger text-center">(Cette demande a pris fin le {{dates_to_french($place->date_fin)}})
                                   </p>

                              </li><br>
                            @endif
                          @empty
                            <p>Vous n'avez aucune place.<br></p>
                            @can('request_booking',App\User::class)
                             <form action ="{{route('booking.store',Auth::user())}}" method=POST>
                             @csrf
                              <input type="submit" class="btn btn-outline-secondary my-1"  onclick="return confirm('En validant cette demande une place vous sera attribué si nous en trouvons une de disponible, le cas échéant vous serez placé en liste d\'attente ');" value="Reserver une place"/>
                             </form>
                          @endcan

                          @endforelse
                          @if($user->reservations)
                            </ul>
                          @endif
                      </div>
                  </div>
            </div>
        </div>
    </div>
</div>
@endsection
