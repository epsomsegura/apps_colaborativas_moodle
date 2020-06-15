@extends('layouts.app')

@section('title','Nuevo perfil académico')
@section('content')

<div class="row">
    <div class="col-12 card">
        <form action="{{url('/profiles/new')}}" method="POST">
            <fieldset>
                @csrf
                <div class="row card-body">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="profile">Perfil</label>
                            <input type="text" name="profile" id="profile" class="form-control" placeholder="Materia" title="Materia" autofocus required>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="description">Descripción</label>
                            <textarea name="description" id="description" class="form-control" rows="5" maxlength="250" placeholder="Descripción" title="Descripción"></textarea>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group text-right">
                            <a href="{{url('/profiles')}}" class="btn btn-secondary">Volver</a>
                            <button class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>

@stop