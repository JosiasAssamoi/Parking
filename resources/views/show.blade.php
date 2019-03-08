@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header text-center">Historique des places</div>

                  <div class="card-body">
                      <div class="wrapper">
                          @if($user->places)
                            <ul class="list-group text-center ">
                          @endif
                          @isset($current_places)
                            @foreach ($current_places as $current_place)
                                  <li  class="list-group-item d-flex justify-content-between align-items-center bg-info">
                                    Place n° {{$current_place->id}} du  {{dates_to_french($current_place->pivot->date)}} au {{finish_date($current_place->pivot->date,$current_place->pivot->duree)}} (Vous possedez actuellement cette place) 
                                    <form action ="{{route('user.delete.place',$current_place->id)}}" method=POST>
                                 @csrf
                                 {{method_field('DELETE')}}
                                <input  type="submit" class="btn  btn-sm btn-secondary"  onclick="return confirm('Êtes-vous sûr de vouloir annuler cette reservation ?');" value="Annuler"/>
                                  </li><br>

                                  
                                </form>
                                      
                            @endforeach
                          @endisset

                          @forelse($user->places as $place)
                            @if (!in_array($place,$current_places))
                              <li  class="list-group-item  ">Place n° {{$place->id}} du  {{dates_to_french($place->pivot->date)}} au
                                  {{finish_date($place->pivot->date,$place->pivot->duree)}} ({{$place->pivot->duree}} jours) 
                                  @if(!empty($place->pivot->deleted_at)) 
                                   <p class ="text-danger text-center">(demande annulée le : {{dates_to_french($place->pivot->deleted_at)}}
                                   )</p>
                                  @endif
                              </li><br>
                            @endif
                          @empty
                            <p>Vous n'avez aucune place.<br></p>
                            <form action ="{{route('user.request',Auth::user())}}" method=POST >
                            <div class="form-group-row">
                             <span>Pour en reserver une</span> 
                              @csrf
                              <input  type="submit" class="  btn btn-sm btn-outline-secondary ml-2"  onclick="return confirm('En validant cette demande une place vous sera attribué si nous en trouvons une de disponible, le cas échéant vous serez placé en liste d\'attente ');" value="Cliquer ici"/> 
                            </div>
                             </form>


                        
                          @endforelse
                          @if($user->places)
                            </ul>
                          @endif
                      </div>
                  </div>
            </div>
        </div>
    </div>
</div>
@endsection

