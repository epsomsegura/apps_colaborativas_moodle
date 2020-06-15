@extends('layouts.app')

@section('title','Materias')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="form-group text-right">
            <a href="{{url('/classes/new')}}" class="btn btn-primary" title="Nueva materia">Nueva materia</a>
        </div>
    </div>
    <div class="col-12">
        <table class="table table-condensed table-hover">
            <thead>
                <tr>
                    <th>Materia</th>
                    <th>Descripción</th>
                    <th>Estatus</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($c as $i)
                <tr>
                    <td>{{$i->classname}}</td>
                    <td>{{$i->description}}</td>
                    <td class="text-center">{{($i->status==1)?'Activo':'Inactivo'}}</td>
                    <td class="text-center">
                        <a href="{{url('/classes/'.Crypt::encrypt($i->id))}}" class="text-primary" title="Editar"><i class="fas fa-edit"></i></a>
                        <a href="#" class="btn_delete text-danger" data-id="{{Crypt::encrypt($i->id)}}" title="Eliminar" data-target="#mdl_delete" data-toggle="modal"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @include('classes.delete')
</div>

<script src="{{asset('js/classes/classes.js')}}"></script>

@stop