@extends('layouts/app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center mb-3"> Gestion des utilisateurs (Admin) </div>
                <div class="wrapper text-center">
                <ul class="list-group  ">
                @if(Session::has('success'))
                <div class ="alert alert-success text-center">
                     {{Session::get('success')}}
                </div>
                @endif
                @forelse($places as $place)
                 <form action= "{{route('place.update',$place->id)}}" method=POST >
                    @method('PUT')
                    @csrf
                 <li  class="list-group-item d-flexalign-items-center ">
                    <li  class="list-group-item"> Place n°{{ $place->id}}
                   
                    @if($place->dispo)
                    <input type ="submit" class ="  btn btn-sm btn-danger "value ="Rendre indispo"></input>
                    @else
                    <input type ="submit" class ="  btn btn-sm btn-success "value ="Rendre dispo"></input>                   
                     @endif

                     </li>
                 </form>
                    @if ($loop->last)
                        <a role ="button" class ="mt-4  btn btn-info "href="{{route('place.create')}}">Creer une place</a>
                        <br><div class="text-center">{{$places->render()}}</div>
                     @endif
                                     <hr/>
                @empty
                Aucune places pour le moment. 
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
