@extends('layouts.app')

@section('title','Editar perfil académico')
@section('content')

<div class="row">
    <div class="col-12 card">
        <form action="{{url('/profiles/'.Crypt::encrypt($p->id))}}" method="POST">
            <fieldset>
                @csrf
                @method('PATCH')
                <div class="row card-body">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="profile">Materia</label>
                            <input type="text" name="profile" id="profile" class="form-control" placeholder="Perfil académico" title="Perfil académico" value="{{$p->profile}}" autofocus required>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="description">Descripción</label>
                            <textarea name="description" id="description" class="form-control" rows="5" maxlength="250" placeholder="Descripción" title="Descripción">{{$p->description}}</textarea>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group text-right">
                            <a href="{{url('/classes')}}" class="btn btn-secondary">Volver</a>
                            <button class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>

@stop