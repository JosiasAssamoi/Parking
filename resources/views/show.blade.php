@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">Historique des places</div>

                  <div class="card-body">
                      <div class="wrapper ">
                          @if($user->places)
                            <ul class="list-group">
                          @endif
                          @isset($current_places)
                            @foreach ($current_places as $current_place)
                                  <li  class="list-group-item active ">Place n° {{$current_place->id}} du  {{datesToFrench($current_place->pivot->date)}} au {{FinishDate($current_place->pivot->date,$current_place->pivot->duree)}} (Vous possedez actuellement cette place) 
                            </li><br>
                            @endforeach
                          @endisset

                          @forelse($user->places as $place)
                            @if (!in_array($place,$current_places))
                              <li  class="list-group-item ">Place n° {{$place->id}} du  {{datesToFrench($place->pivot->date)}} au
                                  {{FinishDate($place->pivot->date,$place->pivot->duree)}} ({{$place->pivot->duree}} jours) 
                              </li><br>
                            @endif
                          @empty
                            <p class ="text-center">Vous n'avez aucune place.<br>
                            Pour en reserver une <a href="" class="">cliquer ici</a></p>
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
