@extends('layouts.app')

@section('title','Estudiantes')
@section('content')
<?php
$alphabet = range('A', 'Z');
?>

<input type="hidden" id="mode" value="R">

<div class="row">
    <div class="col-12 text-right">
        <div class="form-group">
            <a href="{{url('users/students/new')}}" class="btn btn-primary">Nuevo estudiante</a>
        </div>
    </div>
    <div class="col-12">
        <table class="table table-condensed table-hover">
            <thead>
                <tr>
                    <th>Estudiante</th>
                    <th>Correo electrónico <br>(Estudiante)</th>
                    <th>Padre/Tutor</th>
                    <th>Correo electrónico <br>(Padre/tutor)</th>
                    @if(Auth::user()->fk_role==1)<th>Institución</th>@endif
                    <th>Turno</th>
                    <th>Grado</th>
                    <th>Grupo</th>
                    <th>Estatus</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($st as $i)
                <tr>
                    <td>{{$i->se_stud->name}}</td>
                    <td>{{$i->se_stud->email}}</td>
                    <td>{{$i->se_prnt->name}}</td>
                    <td>{{$i->se_prnt->email}}</td>
                    @if(Auth::user()->fk_role==1)<td>{{$i->se_inst->name}}</td>@endif
                    <td>{{$i->shift}}</td>
                    <td>{{$i->grade}}</td>
                    <td>{{$alphabet[$i->group_class-1]}}</td>
                    <td>{{($i->status == 1) ? 'Activo': 'Inactivo'}}</td>
                    <td class="text-center">
                        @if($i->status == 1)
                        <a href="{{url('/users/students/'.Crypt::encrypt($i->id))}}" class="btn_edit text-primary" title="Editar"><i class="fas fa-edit"></i></a>
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
    @include('users.students.disable')
    @include('users.students.enable')
</div>

<script src="{{asset('js/users/students_expedients.js')}}"></script>

@stop