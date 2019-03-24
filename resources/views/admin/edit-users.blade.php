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
                @forelse($users as $user)
                 <li  class="list-group-item d-flexalign-items-center ">
                    <li  class="list-group-item">{{$user->name}}
                    </li>



                <hr/>
                @empty
                Aucun utilisateur pour  le moment. 
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
