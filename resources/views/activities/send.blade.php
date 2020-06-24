@extends('layouts.app')

@section('title','Enviar actividad')
@section('content')

<div class="row">
    <div class="col-12 card">
        <form action="{{url('/activities/send/'.Crypt::encrypt($ast->id))}}" method="POST" enctype="multipart/form-data">
            <fieldset>
                @csrf 
                <div class="row card-body">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="response">Mensaje de respuesta</label>
                            <textarea name="response" id="response" class="form-control" rows="5" maxlength="2000" placeholder="Mensaje de respuesta" title="Mensaje de respuesta"></textarea>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="file_response">Cargar archivo de actividad (zip, pdf)</label>
                            <label for="file_response" class="btn btn-secondary btn-block">
                                Cargar archivo
                                <input type="file" name="file_response" id="file_response">
                            </label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group text-right">
                            <a href="{{url('/activities')}}" class="btn btn-secondary">Volver</a>
                            <button class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>

@stop