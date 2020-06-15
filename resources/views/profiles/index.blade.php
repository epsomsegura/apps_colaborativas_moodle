@extends('layouts.app')

@section('title','Perfiles académicos')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="form-group text-right">
            <a href="{{url('/profiles/new')}}" class="btn btn-primary" title="Nueva materia">Nuevo perfil académico</a>
        </div>
    </div>
    <div class="col-12">
        <table class="table table-condensed table-hover">
            <thead>
                <tr>
                    <th>Perfil académico</th>
                    <th>Descripción</th>
                    <th>Estatus</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($p as $i)
                <tr>
                    <td>{{$i->profile}}</td>
                    <td>{{$i->description}}</td>
                    <td class="text-center">{{($i->status==1)?'Activo':'Inactivo'}}</td>
                    <td class="text-center">
                        <a href="{{url('/profiles/'.Crypt::encrypt($i->id))}}" class="text-primary" title="Editar"><i class="fas fa-edit"></i></a>
                        <a href="#" class="btn_delete text-danger" data-id="{{Crypt::encrypt($i->id)}}" title="Eliminar" data-target="#mdl_delete" data-toggle="modal"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @include('profiles.delete')
</div>

<script src="{{asset('js/profiles/profiles.js')}}"></script>

@stop