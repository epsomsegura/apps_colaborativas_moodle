@extends('layouts.app')

@section('title','Roles')
@section('content')

<div class="row">
    <div class="col-12 text-right">
        <div class="form-group">
            <a href="{{url('/roles/new')}}" class="btn btn-primary">Nuevo rol</a>
        </div>
    </div>
    <div class="col-12">
        <div class="table-responsive">
            <table class="table table-condensed table-hover">
                <thead>
                    <tr>
                        <th>Rol</th>
                        <th>Descripción</th>
                        <th>Estatus</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($role as $r)
                    <tr>
                        <td>{{$r->role}}</td>
                        <td>{{$r->description}}</td>
                        <td>{{($r->status == 1) ? 'Activo' : 'Inactivo'}}</td>
                        <td class="text-center">
                            <a href="{{url('/roles/'.Crypt::encrypt($r->id))}}" class="text-primary" title="Editar"><i class="fas fa-edit"></i></a>
                            <a href="#" class="btn_delete text-danger" data-id="{{Crypt::encrypt($r->id)}}" title="Eliminar" data-target="#mdl_delete" data-toggle="modal"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @include('roles.delete')
</div>


<script src="{{asset('js/roles/roles.js')}}"></script>

@stop