@extends('layouts.app')

@section('title','Actividades del estudiante')
@section('content')

<div class="row">
    <div class="col-12">
        <table class="table table-condensed table-hover">
            <thead>
                <tr>
                    <th>Estudiante</th>
                    <th>Materia</th>
                    <th>Actividad</th>
                    <th>Fechas</th>
                    <th>Estatus</th>
                    <th>Calificación</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
            @foreach($ast as $i)
                <tr>
                    <td>{{$i->ast_st->se_stud->name}}</td>
                    <td>{{$i->ast_a->a_ic->ic_c->classname}}</td>
                    <td>
                        <h6>{{$i->ast_a->instruction}}</h6>
                        <span>{{$i->ast_a->request}}</span>
                        <br>
                        <small>
                        @if($i->ast_a->file_request != NULL)
                        <a href="{{url($i->ast_a->file_request)}}" target="_BLANK" class="text-primary">Descargar archivo</a>
                        @else
                        {{'No cargó archivo'}}
                        @endif
                        </small>
                    </td>
                    <td>
                        <small>
                        {{'Inicio: '.$i->ast_a->start}}
                        {{'Cierre: '.$i->ast_a->end}}
                        </small>
                    </td>
                    <td>
                        @switch($i->status)
                        @case(0)
                        {{'Sin enviar'}}
                        @break
                        @case(1)
                        {{'Enviado'}}
                        @break
                        @case(2)
                        {{'Revisado'}}
                        @break
                        @endswitch
                    </td>
                    <td>
                        <input type="number" min="0" max="100" class="form-control text-center" value="{{$i->score}}" readonly>
                    </td>
                    <td class="text-center">
                        @if($i->status == 0)
                        <a href="{{url('activities/send/'.Crypt::encrypt($i->id))}}" class="text-primary btn_score" data-id="{{$i->id}}"><i class="fas fa-upload"></i></a>
                        @elseif($i->status == 1)
                        <a href="{{url('activities/send/'.Crypt::encrypt($i->id))}}" class="text-primary btn_score" data-id="{{$i->id}}"><i class="fas fa-upload"></i></a>
                        @elseif($i->status == 2)
                        <a href="{{url('activities/send/'.Crypt::encrypt($i->id))}}" class="text-primary btn_score" data-id="{{$i->id}}"><i class="fas fa-eye"></i></a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-12">
        <div class="form-group text-right">
            <a href="{{url('/activities')}}" class="btn btn-secondary">Volver</a>
        </div>
    </div>
</div>

@stop