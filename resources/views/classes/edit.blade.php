@extends('layouts.app')

@section('title','Editar materia')
@section('content')

<div class="row">
    <div class="col-12 card">
        <form action="{{url('/classes/'.Crypt::encrypt($c->id))}}" method="POST">
            <fieldset>
                @csrf
                @method('PATCH')
                <div class="row card-body">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="classname">Materia</label>
                            <input type="text" name="classname" id="classname" class="form-control" placeholder="Materia" title="Materia" value="{{$c->classname}}" autofocus required>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="description">Descripción</label>
                            <textarea name="description" id="description" class="form-control" rows="5" maxlength="250" placeholder="Descripción" title="Descripción">{{$c->description}}</textarea>
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