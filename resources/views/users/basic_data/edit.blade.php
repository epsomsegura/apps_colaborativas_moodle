@extends('layouts.app')

@section('title','Editar usuario')
@section('content')

<div class="row">
    <div class="card col-12">
        <form action="{{url('/users/'.Crypt::encrypt($u->id))}}" method="POST">
            <fieldset>
                @csrf
                @method('PATCH')
                <div class="card-body row">
                    <div class="col-12 col-sm-8">
                        <div class="form-group">
                            <label for="name">Nombre completo</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Nombre completo" title="Nombre completo" maxlength="150" value="{{$u->name}}" required autofocus>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="form-group">
                            <label for="fk_role">Tipo de usuario</label>
                            <select name="fk_role" id="fk_role" class="form-control" title="Tipo de usuario" requires>
                                <option value="" disabled>Seleccione uno</option>
                                @foreach($role as $i)
                                @if($i->id == $u->fk_role)
                                <option value="{{$i->id}}" selected>{{$i->role}}</option>
                                @else
                                <option value="{{$i->id}}">{{$i->role}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="form-group">
                            <label for="email">Correo electrónico</label>
                            <input type="mail" id="email" name="email" class="form-control" placeholder="Correo electrónico" title="Correo electrónico" maxlength="150" value="{{$u->email}}" required>
                        </div>
                    </div>
                    <div class="col-12 col-sm-8">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group" style="margin-bottom: 0.5rem !important;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="chk_password">
                                        <label class="form-check-label" for="chk_password">¿Cambiar contraseña?<label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row" id="password_container"></div>
                            </div>
                        </div>
                    </div>
                    
                    @if(Auth::user()->fk_role == 1 && $u->fk_role != 4)
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="state">Estados</label>
                            <select class="form-control" id="state">
                                <option value="" disabled selected>Seleccione uno</option>
                                @foreach($s as $s)
                                @if($s->id == $idEst)
                                <option value="{{$s->id}}" selected>{{$s->estado}}</option>
                                @else
                                <option value="{{$s->id}}">{{$s->estado}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="county">Municipios</label>
                            <select class="form-control" id="county">
                                <option value="" disabled>Seleccione uno</option>
                                @foreach($m as $m)
                                @if($m->id == $idMun)
                                <option value="{{$m->id}}" selected>{{$m->municipio}}</option>
                                @else
                                <option value="{{$m->id}}">{{$m->municipio}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="fk_institute">Instituto</label>
                            <select name="fk_institute" id="fk_institute" class="form-control" required>
                                <option value="" disabled>Seleccione uno</option>
                                @foreach($ins as $i)
                                @if($i->id == $u->fk_institute)
                                <option value="{{$i->id}}" selected>{{$i->name}}</option>
                                @else
                                <option value="{{$i->id}}">{{$i->name}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @else
                    <input type="hidden" name="fk_institute" value="{{Auth::user()->fk_institute}}">
                    @endif
                    <div class="col-12">
                        <div class="form-group text-right">
                            <a href="{{url('/users')}}" class="btn btn-secondary">Volver</a>
                            <button type="button" id="btn_save" class="btn btn-primary">Guardar</button>
                            <input type="submit" id="btn_send" value="" hidden>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>

<script src="{{asset('js/users/users.js')}}"></script>

@stop