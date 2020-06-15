@extends('layouts.app')

@section('title','Asignación de materias')
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
                    <th>Descripción</th>
                    @if(Auth::user()->fk_role == 1)<th>Instituto</th>@endif
                    <th>Turno</th>
                    <th>Grado</th>
                    <th>Grupo</th>
                    <th>Docente</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ic as $i)
                <tr>
                    <td>{{$i->ic_c->classname}}</td>
                    <td>{{$i->ic_c->description}}</td>
                    @if(Auth::user()->fk_role==1)<td>{{$i->ic_i->name}}</td>@endif
                    <td>{{($i->shift == 'M') ? 'Matutino':'Vespertino'}}</td>
                    <td class="text-center">{{$i->classgrade}}</td>
                    <td class="text-center">{{$alphabet[$i->classgroup-1]}}</td>
                    <td>
                        <select class="form-control fk_teacher" data-id="{{$i->id}}">
                            <option value="" disabled selected>Seleccione uno</option>
                            @foreach($i->teachers as $j)
                            @if($i->fk_teacher == $j->te_teach->id)
                            <option value="{{$j->te_teach->id}}" selected>{{$j->te_teach->name}} ({{$j->te_prof->profile}})</option>
                            @else
                            <option value="{{$j->te_teach->id}}">{{$j->te_teach->name}} ({{$j->te_prof->profile}})</option>
                            @endif
                            @endforeach
                        </select>
                    </td>
                    <td class="text-center">
                        <a href="#" class="btn_assign text-primary" title="Editar"><i class="fas fa-edit"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @include('institute_classes.delete')
</div>

<script src="{{asset('/js/instituteclasses/instituteclasses.js')}}"></script>

@stop