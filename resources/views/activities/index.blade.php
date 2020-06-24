@extends('layouts.app')

@section('title','Actividades')
@section('content')
<?php
$alphabet = range('A','Z');
?>

<div class="row">
    <div class="col-12">
        <div class="form-group text-right">
            <a href="{{url('activities/new')}}" class="btn btn-primary">Nueva actividad</a>
        </div>
    </div>
    <div class="col-12">
        <table class="table table-condensed table-hover">
            <thead>
                <tr>
                    @if(in_array(Auth::user()->fk_role,[1,3]))<th>Instituto</th>@endif
                    @if(in_array(Auth::user()->fk_role,[1,2]))<th>Docente</th>@endif
                    @if(in_array(Auth::user()->fk_role,[1,2,3]))<th>Materia</th>@endif
                    <th>Turno</th>
                    <th>Grado</th>
                    <th>Grupo</th>
                    <th>Descripción</th>
                    <th>Archivo</th>
                    <th>Inicio</th>
                    <th>Cierre</th>
                    <th>Status</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($a as $i)
                <tr>
                    @if(in_array(Auth::user()->fk_role,[1,3]))<td>{{$i->a_i->name}}</td>@endif
                    @if(in_array(Auth::user()->fk_role,[1,2]))<td>{{$i->a_t->name}}</td>@endif
                    @if(in_array(Auth::user()->fk_role,[1,2,3]))<td>{{$i->a_ic->ic_c->classname}}</td>@endif
                    <td>{{($i->a_ic->shift=='M') ? 'Matutino':'Vespertino'}}</td>
                    <td class="text-center">{{$i->a_ic->classgrade}}</td>
                    <td class="text-center">{{$alphabet[$i->a_ic->classgrade -1]}}</td>
                    <td>
                        <h5>{{$i->instruction}}</h5>
                        {{$i->request}}
                    </td>
                    <td class="text-center">
                        @if($i->file_request != null)

                        @else
                        'Sin archivo'
                        @endif
                    </td>
                    <td class="text-center">{{$i->start}}</td>
                    <td class="text-center">{{$i->end}}</td>
                    <td class="text-center">{{$i->status == 1 ? 'Abierta' : 'Cerrada'}}</td>
                    <td class="text-center">
                        <a href="{{url('/activities/'.Crypt::encrypt($i->id))}}" class="text-primary" title="Editar"><i class="fas fa-edit"></i></a>
                        <a href="{{url('/activities/scores/'.Crypt::encrypt($i->id))}}" class="text-dark" title="Revisar"><i class="fas fa-check"></i></a>
                    </td>
                </tr>

                @endforeach
            </tbody>
        </table>
    </div>
</div>

@stop