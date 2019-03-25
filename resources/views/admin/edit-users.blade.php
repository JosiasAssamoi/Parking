@extends('layouts/app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header text-center mb-3"> Gestion des utilisateurs (Admin) </div>
                <div class="card-body">
                <div class="wrapper text-center">
                <ul class="list-group text-center ">
                @if(Session::has('success'))
                <div class ="alert alert-success text-center">
                     {{Session::get('success')}}
                </div>
                @endif
                @forelse($users as $user)
                 <li class="list-group-item d-flex justify-content-between align-items-center">
                  
                    {{$user->name." ".$user->firstname}}
                        @if (!empty($user->getCurrrentPlace()))
                        <form action ="{{route('user.delete.place',$user->getCurrrentPlace()->place_id)}}" method=POST>
                 @csrf
                 {{method_field('DELETE')}}
                <input  type="submit" class="btn  btn-sm btn-secondary"  onclick="return confirm('Êtes-vous sûr de vouloir annuler cette reservation ?');" value="Annuler"/>


                </form>
                @endif

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
</div>

@stop