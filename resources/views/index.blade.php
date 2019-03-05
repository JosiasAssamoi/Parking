@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">Tableau de bord</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="wrapper text-center">

                   <a href="" class="btn btn-outline-secondary" role="button">Reserver une place</a>
                   <a href="{{ route('user.edit',['user'=> Auth::user()] ) }}" class="btn btn-outline-secondary" role="button">Editer votre profil</a>
               </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
