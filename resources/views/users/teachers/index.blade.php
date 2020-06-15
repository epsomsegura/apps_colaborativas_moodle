@extends('layouts.app')

@section('title','Docentes')
@section('content')

<input type="hidden" id="mode" value="R">

<div class="row">
    <div class="col-12 text-right">
        <div class="form-group">
            <a href="{{url('/users/teachers/new')}}" class="btn btn-primary">Nuevo docente</a>
        </div>
    </div>
    <div class="col-12">
        <table class="table table-condensed table-hover">
            <thead>
                <tr>
                    <th>Estudiante</th>
                    <th>Correo electrónico</th>
                    @if(Auth::user()->fk_role==1)<th>Institución</th>@endif
                    <th>Perfil académico</th>
                    <th>Estatus</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tc as $i)
                <tr>
                    <td>{{$i->te_teach->name}}</td>
                    <td>{{$i->te_teach->email}}</td>
                    @if(Auth::user()->fk_role==1)<td>{{$i->te_inst->name}}</td>@endif
                    <td>{{$i->te_prof->profile}}</td>
                    <td>{{($i->status == 1) ? 'Activo': 'Inactivo'}}</td>
                    <td class="text-center">
                        @if($i->status == 1)
                        <a href="{{url('/users/teachers/'.Crypt::encrypt($i->id))}}" class="btn_edit text-primary" title="Editar"><i class="fas fa-edit"></i></a>
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
    @include('users.teachers.disable')
    @include('users.teachers.enable')
</div>

<script src="{{asset('js/users/teachers_expedients.js')}}"></script>

@stop