@extends('layouts.app')

@section('title','Mi perfil')
@section('content')

<div class="row">
    <div class="card col-12">
        <form action="{{url('/users/myProfile')}}" method="POST">
            <fieldset>
                @csrf
                @method('PATCH')
                <div class="card-body row">
                    <div class="col-12">
                        <small><span class="text-danger">* Al cambiar los datos, la sesión será terminada y deberá iniciarla nuevamente</span></small>
                    </div>
                    <div class="col-12 col-sm-8">
                        <div class="form-group">
                            <label for="name">Nombre completo</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Nombre completo" title="Nombre completo" maxlength="150" value="{{$u->name}}" required autofocus>
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

                    <div class="col-12">
                        <div class="form-group text-right">
                            <a href="{{url('/home')}}" class="btn btn-secondary">Volver</a>
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