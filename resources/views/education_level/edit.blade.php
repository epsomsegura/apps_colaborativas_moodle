@extends('layouts.app')

@section('title','Editar nivel educativo')
@section('content')


<div class="row">
    <div class="card col-12">
        <form action="{{url('/education_level/'.Crypt::encrypt($el->id))}}" method="POST">
            <fieldset>
                @csrf
                @method('PATCH')
                <div class="card-body row">
                    <div class="col-12 col-sm-3">
                        <div class="form-group">
                            <label for="name">Nivel educativo</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Nivel educativo" title="Nivel educativo" value="{{$el->name}}" required maxlength="30" autofocus>
                        </div>
                    </div>
                    <div class="col-12 col-sm-9">
                        <div class="form-group">
                            <label for="description">Descripción</label>
                            <input type="text" id="description" name="description" class="form-control" placeholder="Descripción" title="Descripción" value="{{$el->description}}" required maxlength="250">
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="form-group text-right">
                            <a href="{{url('/education_level')}}" class="btn btn-secondary">Volver</a>
                            <button class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>

<script src="{{asset('js/education_levels/education_levels.js')}}"></script>
@stop