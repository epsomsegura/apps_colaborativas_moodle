@extends('layouts.app')

@section('title','Editar rol')
@section('content')


<div class="row">
    <div class="card col-12">
        <form action="{{url('/roles/'.Crypt::encrypt($r->id))}}" method="POST">
            <fieldset>
                @csrf
                @method('PATCH')
                <div class="card-body row">
                    <div class="col-12 col-sm-3">
                        <div class="form-group">
                            <label for="role">roles</label>
                            <input type="text" id="role" name="role" class="form-control" placeholder="Rol" title="Rol" value="{{$r->role}}" required maxlength="20" autofocus>
                        </div>
                    </div>
                    <div class="col-12 col-sm-9">
                        <div class="form-group">
                            <label for="description">Descripción</label>
                            <input type="text" id="description" name="description" class="form-control" placeholder="Descripción" title="Descripción" value="{{$r->description}}" required maxlength="250">
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="form-group text-right">
                            <a href="{{url('/roles')}}" class="btn btn-secondary">Volver</a>
                            <button class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>

<script src="{{asset('js/roles/roles.js')}}"></script>
@stop