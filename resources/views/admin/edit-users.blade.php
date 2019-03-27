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

                    <div class="wrapper d-block">
                    <form action ="{{route('admin.reset-pass',$user)}}" method=POST>
                    @csrf
                    {{$user->name." ".$user->firstname}}
                    <button  title= "re-initialiser le mot de passe" type="submit" class="btn btn-sm"  onclick="return confirm('Êtes-vous sûr de vouloir re-initialiser le mot de passe de cet utilisateur  ?');" >
                    <i class="fas fa-key"></i>
                    </button>
                  </form>
                   <form action ="{{ route('user.destroy',['user'=> $user] ) }}" method=POST>
                    @csrf
                    @method('DELETE')
                    <button  title= "supprimer cet utilisateur" type="submit" class="btn btn-sm btn-danger"  onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur  ?');" >
                   <i class="fas fa-user-times"></i>
                    </button>
                  </form>
                  </div>

                        @if (!empty($user->getCurrrentPlace()))
                        <form action ="{{route('user.delete.place',$user->getCurrrentPlace()->place_id)}}" method=POST>
                          <span>Possède la place n° {{$user->getCurrrentPlace()->place_id}}</span>
                 @csrf
                 {{method_field('DELETE')}}
                <input  type="submit" class="btn  btn-sm btn-danger"  onclick="return confirm('Êtes-vous sûr de vouloir annuler cette reservation ?');" value="Annuler"/>


                </form>
                @else

                <form action ="{{route('admin.place-assignement',$user)}}"  method = POST>
                  @csrf
                      <select required class="browser-default" name="choix_place">
                        <option selected="" disabled hidden ></option>
                            @foreach($places as $place)
                              <option value="{{$place->id}}" >{{$place->id}}</option>
                            @endforeach
                      </select>
                </select>
                <input type ="submit" class="btn btn-sm btn-secondary" onclick ="return confirm ('Êtes-vous sûr de vouloir attribuer cette place ?');" value="Attribuer"/>
              </form>
                @endif
              </span>

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
