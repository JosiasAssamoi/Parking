@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header text-center">Historique des places</div>
                  <div class="card-body">
                      <div class="wrapper">
                          @if($user->reservations)
                            <ul class="list-group text-center ">
                          @endif
                          @isset($current_place)
                          
                                  <li  class="list-group-item d-flex justify-content-between align-items-center bg-info">
                                    Place n° {{$current_place->place_id}} du  {{dates_to_french($current_place->date_debut)}} au {{dates_to_french($current_place->date_fin)}} (Vous possedez actuellement cette place)
                                    <form action ="{{route('user.delete.place',$current_place->place_id)}}" method=POST>
                                 @csrf
                                 {{method_field('DELETE')}}
                                <input  type="submit" class="btn  btn-sm btn-secondary"  onclick="return confirm('Êtes-vous sûr de vouloir annuler cette reservation ?');" value="Annuler"/>
                                  </li><br>


                                </form>
                          @endisset

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
                             <form action ="{{route('user.request',Auth::user())}}" method=POST>
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
