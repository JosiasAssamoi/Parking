@extends('layouts/app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center mb-3"> Liste des demandes a valider(Admin) </div>
                <div class="wrapper text-center">
                <ul class="list-group  ">
                @if(Session::has('success'))
                <div class ="alert alert-success text-center">
                     {{Session::get('success')}}
                </div>
                @endif
                @forelse($users as $user)
                 <li  class="list-group-item d-flex justify-content-between align-items-center ">
                <span><b>{{ucfirst($user->name)." ".$user->firstname}}</b> est en attente de validation</span>
                <form action ="{{route('registering.update',$user)}}" method=POST>
                        @csrf
                        {{method_field('PATCH')}}
                        <input  type="submit" class="btn  btn-sm btn-outline-success"  value="Valider"/>
                        </li><br>
                </form>
                <hr/>



                @empty
                Il n'y a aucune demandes d'inscriptions a valider
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
