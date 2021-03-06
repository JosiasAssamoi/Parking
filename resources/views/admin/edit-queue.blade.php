@extends('layouts/app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center mb-3"> Rang des utilisateurs (Admin) </div>
                <div class="wrapper text-center">
                <ul class="list-group  ">
                @if(Session::has('success'))
                <div class ="alert alert-success text-center">
                     {{Session::get('success')}}
                </div>
                @endif
                <form action ="{{route('queue.update',['queue'=>1])}}" method=POST>
                    @csrf
                    {{method_field('PATCH')}}
                    @forelse($users->sortBy('rang') as $user)

                            <li  class="list-group-item d-flex justify-content-between align-items-center ">
                                <span><b>{{ucfirst($user->name)." ".$user->firstname}}</b></span>
                                <select class="browser-default" name="choix_rang[{{$user->id}}]">
                                    @foreach($users as $rang)
                                            <option selected="{{$user->rang}} " disabled hidden >{{$user->rang}}</option>
                                            @if($loop->first)
                                                <option value="-1" >Supprimer de la liste</option>
                                            @endif
                                            @if($rang->rang !=$user->rang)
                                                    <option value="{{$rang->rang}}" >{{$rang->rang}}</option>
                                            @endif
                                    @endforeach
                                </select>

                            </li><br>
                            <hr/>
                    @empty
                    Il n'y a aucun utilisateur dans la liste d'attente
                    @endforelse
                    @isset($user)
                    <input  type="submit" class="btn  btn-sm btn-outline-info"  value="Modifier"/>
                    @endisset
                </form>
              </ul>
              </div>
               </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop
