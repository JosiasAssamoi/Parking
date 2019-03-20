@extends('layouts/app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center mb-3"> Liste des demandes a valider(Admin) </div>
                <div class="wrapper text-center">
                @forelse($users as $user)
                {{$user->name." ".$user->firstname}} est en attente de validation
                <a href="{{ route('admin.edit-register-requests') }}" class="btn btn-sm btn-outline-success " role="button">Valider</a>
                </br>
                <hr/>



                @empty
                Il n'y a aucune demandes d'inscriptions a valider
                @endforelse
              </div>
               </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop
