@extends('layouts.app')

@section('title','Niveles educativos')
@section('content')

<div class="row">
    <div class="col-12 text-right">
        <div class="form-group">
            <a href="{{url('/education_level/new')}}" class="btn btn-primary">Nuevo nivel educativo</a>
        </div>
    </div>
    <div class="col-12">
        <table class="table table-condensed table-hover">
            <thead>
                <tr>
                    <th>Nivel educativo</th>
                    <th>Descripción</th>
                    <th>Estatus</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($el as $i)
                <tr>
                    <td>{{$i->name}}</td>
                    <td>{{$i->description}}</td>
                    <td>{{($i->status == 1) ? 'Activo' : 'Inactivo'}}</td>
                    <td class="text-center">
                        <a href="{{url('/education_level/'.Crypt::encrypt($i->id))}}" class="text-primary" title="Editar"><i class="fas fa-edit"></i></a>
                        <a href="#" class="btn_delete text-danger" data-id="{{Crypt::encrypt($i->id)}}" title="Eliminar" data-target="#mdl_delete" data-toggle="modal"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @include('education_level.delete')
</div>


<script src="{{asset('js/education_levels/education_levels.js')}}"></script>

@stop