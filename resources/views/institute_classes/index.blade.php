@extends('layouts.app')

@section('title','Materias del instituto')
@section('content')

<?
$alphabet = range('A','Z');
?>

<div class="row">
    <div class="col-12 text-right">
        <div class="form-group">
            <a href="{{url('/institute_classes/new')}}" class="btn btn-primary">Nueva materia</a>
        </div>
    </div>
    <div class="col-12">
        <table class="table table-condensed table-hover">
            <thead>
                <tr>
                    <th>Materia</th>
                    <th>Descripción</th>
                    <th>Instituto</th>
                    @if(Auth::user()->fk_role == 1)<th>Instituto</th>@endif
                    <th>Turno</th>
                    <th>Grados</th>
                    <th>Grupos</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($c as $i)
                <tr>
                    <td>{{$i->ic_c->classname}}</td>
                    <td>{{$i->ic_c->description}}</td>
                    <td>{{$i->ic_i->name}}</td>
                    @if(Auth::user()->fk_role==1)<td>{{$i->ic_i->name}}</td>@endif
                    <td>{{($i->shift == 'M') ? 'Matutino':'Vespertino'}}</td>
                    <td>
                        @foreach($i->grades as $k=>$j)
                        <small>
                            <span class="badge badge-{{($j->status==1)?'success':'danger'}}">Grado {{$j->classgrade}}</span>
                        </small>
                        @endforeach
                    </td>
                    <td>
                        @foreach($i->groups as $k=>$j)
                        <small>
                            <span class="badge badge-{{($j->status==1)?'success':'danger'}}">Grupo {{$alphabet[$j->classgroup-1]}}</span>
                        </small>
                        @endforeach
                    </td>
                    <td class="text-center">
                        <a href="{{url('/institute_classes/'.Crypt::encrypt($i->id))}}" class="text-primary" title="Editar"><i class="fas fa-edit"></i></a>
                        <a href="#" class="btn_delete text-danger" data-id="{{Crypt::encrypt($i->id)}}" title="Eliminar" data-target="#mdl_delete" data-toggle="modal"><i class="fas fa-trash"></i></a>
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