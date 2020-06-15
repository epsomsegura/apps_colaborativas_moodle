@extends('layouts.app')

@section('title','Usuarios')
@section('content')

<div class="row">
    <div class="col-12 text-right">
        <div class="form-group">
            <a href="{{url('users/new')}}" class="btn btn-primary">Nuevo usuario</a>
        </div>
    </div>
    <div class="col-12">
        <table class="table table-condensed table-hover">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Rol</th>
                    <th>Correo electrónico</th>
                    <th>Estatus</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($u as $i)
                <tr>
                    <td>{{$i->name}}</td>
                    <td>{{$i->u_r->role}}</td>
                    <td>{{$i->email}}</td>
                    <td>{{($i->status == 1) ? 'Activo': 'Inactivo'}}</td>
                    <td class="text-center">
                        <a href="{{url('/users/'.Crypt::encrypt($i->id))}}" class="btn_edit text-primary" title="Editar"><i class="fas fa-edit"></i></a>
                        <a href="#" class="btn_delete text-danger" data-id="{{Crypt::encrypt($i->id)}}" title="Eliminar" data-target="#mdl_delete" data-toggle="modal"><i class="fas fa-trash"></i></a>
                        @if($i->status==1)
                        <a href="#" class="btn_disable text-danger" data-id="{{Crypt::encrypt($i->id)}}" title="Deshabilitar" data-target="#mdl_disable" data-toggle="modal"><i class="fas fa-ban"></i></a>
                        @else
                        <a href="#" class="btn_enable text-success" data-id="{{Crypt::encrypt($i->id)}}" title="Habilitar" data-target="#mdl_enable" data-toggle="modal"><i class="fas fa-check"></i></a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @include('users.basic_data.delete')
    @include('users.basic_data.disable')
    @include('users.basic_data.enable')
</div>

<script src="{{asset('js/users/users.js')}}"></script>

@stop