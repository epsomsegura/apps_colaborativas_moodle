@extends('layouts.app')

@section('title','Nuevo usuario')
@section('content')

<div class="row">
    <div class="card col-12">
        <form action="#" method="POST">
            <fieldset>
                @csrf
                <div class="card-body row">
                    <div class="col-12 col-sm-8">
                        <div class="form-group">
                            <label for="name">Nombre completo</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Nombre completo" title="Nombre completo" maxlength="150" required autofocus>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="form-group">
                            <label for="fk_role">Tipo de usuario</label>
                            <select name="fk_role" id="fk_role" class="form-control" title="Tipo de usuario" requires>
                                <option value="" disabled selected>Seleccione uno</option>
                                @foreach($role as $i)
                                <option value="{{$i->id}}">{{$i->role}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="form-group">
                            <label for="email">Correo electrónico</label>
                            <input type="mail" id="email" name="email" class="form-control" placeholder="Correo electrónico" title="Correo electrónico" maxlength="150" required>
                        </div>
                    </div>
                    <div class="col-12 col-sm-8">
                        <div class="row">
                            <div class="col-12 col-sm-5">
                                <div class="form-group">
                                    <label for="password">Contraseña</label>
                                    <input type="password" id="password" name="password" class="form-control" placeholder="Contraseña" title="Contraseña" required>
                                </div>
                            </div>
                            <div class="col-12 col-sm-5">
                                <div class="form-group">
                                    <label for="password2">Repita la contraseña</label>
                                    <input type="password" id="password2" name="password2" class="form-control" placeholder="Repita la contraseña" title="Repita la contraseña" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(Auth::user()->fk_role == 1)
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="state">Estados</label>
                            <select class="form-control" id="state">
                                <option value="" disabled>Seleccione uno</option>
                                @foreach($s as $s)
                                <option value="{{$s->id}}" >{{$s->estado}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="county">Municipios</label>
                            <select class="form-control" id="county">
                                <option value="" disabled selected>Seleccione uno</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="fk_institute">Instituto</label>
                            <select name="fk_institute" id="fk_institute" class="form-control" required>
                                <option value="" disabled selected>Seleccione uno</option>
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