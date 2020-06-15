@extends('layouts.app')

@section('title','Estudiantes por materia')
@section('content')

<?
$alphabet = range('A','Z');
?>

<div class="row">
    @csrf
    <div class="col-12">
        <table class="table table-condensed table-hover">
            <thead>
                <tr>
                    <th>Materia</th>
                    <th>Instituto</th>
                    @if(Auth::user()->fk_role == 1)<th>Instituto</th>@endif
                    <th>Turno</th>
                    <th>Grado</th>
                    <th>Grupo</th>
                    <th>Total</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ic as $i)
                <tr>
                    <td>{{$i->ic_c->classname}}</td>
                    <td>{{$i->ic_i->name}}</td>
                    @if(Auth::user()->fk_role==1)<td>{{$i->ic_i->name}}</td>@endif
                    <td>{{($i->shift == 'M') ? 'Matutino':'Vespertino'}}</td>
                    <td class="text-center">{{$i->classgrade}}</td>
                    <td class="text-center">{{$alphabet[$i->classgroup-1]}}</td>
                    <td class="text-center">{{$i->total}}</td>
                    <td class="text-center">
                        <a href="#" class="btn_list text-primary" title="Ver estudiantes" data-list="{{$i->list}}" data-grade="{{$i->classgrade}}" data-group="{{$alphabet[$i->classgroup-1]}}" data-classname="{{$i->ic_c->classname}}" data-target="#mdl_list" data-toggle="modal"><i class="fas fa-list"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @include('institute_classes.studentslist')
</div>

<script src="{{asset('/js/instituteclasses/instituteclasses.js')}}"></script>

@stop