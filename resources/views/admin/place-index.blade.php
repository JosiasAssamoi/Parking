@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">Edition des places (Admin) </div>

                    @if(isset($request_response) || $request_response=Session::get('request_response'))

                    <div class ="alert alert-{{$request_response['status']}} text-center">
                      {{$request_response['msg']}}
                    </div>

                    @endif
                    <div class="wrapper text-center">
                   <a href="{{ route('place.index') }}" class="btn btn-outline-secondary my-1" role="button">Editer les places</a>
                   <hr/>
               </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection