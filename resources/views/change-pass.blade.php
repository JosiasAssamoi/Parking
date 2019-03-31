@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">{{ __('Modifier votre mot de passe') }}</div>
                <div class="card-body ">
                	<form method="POST" action="{{ route('userchangepass.update',Auth::user()) }}">
                        @csrf
                        @method('PATCH')

                        @if(Session::has('error'))
                            <div class ="alert alert-danger">
                                {{Session::get('error')}}
                            </div>
                        @endif
                         @if(Session::has('success'))
                            <div class ="alert alert-success">
                                {{Session::get('success')}}
                            </div>
                        @endif

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Mot de passe actuel') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required autofocus>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                              <div class="form-group row">
                            <label for="newpassword" class="col-md-4 col-form-label text-md-right">{{ __('Nouveau mot de passe') }}</label>
                            <div class="col-md-6">
                                <input id="newpassword" type="password" class="form-control{{ $errors->has('newpassword') ? ' is-invalid' : '' }}" name="newpassword" required autofocus>

                                @if ($errors->has('newpassword'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('newpassword') }}</strong>
                                    </span>
                                @endif
                            
                            </div></div>

                             <div class="form-group row">
                            <label for="confirm-password" class="col-md-4 col-form-label text-md-right">{{ __('Confirmer votre nouveau mot de passe') }}</label>
                            <div class="col-md-6">
                                <input id="confirm-password" type="password" class="form-control{{ $errors->has('confirm-password') ? ' is-invalid' : '' }}" name="confirm-password" required autofocus>

                                @if ($errors->has('confirm-password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('confirm-password') }}</strong>
                                    </span>
                                @endif
                            </div>


                        </div>
                            <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Modifier') }}
                                </button>
                            </div>
                        </div>

                </div>
            </div>
        </div>
    </div>
</div>


@endsection
