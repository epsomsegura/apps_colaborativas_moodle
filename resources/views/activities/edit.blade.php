@extends('layouts.app')

@section('title','Editar actividad')
@section('content')

<?php
$alphabet = range('A','Z');
?>

<input type="hidden" id="mode" value="E">
<input type="hidden" id="hdn_institute" value="{{$a->fk_institute}}">
<input type="hidden" id="hdn_teacher" value="{{$a->fk_teacher}}">
<input type="hidden" id="hdn_shift" value="{{$a->a_ic->shift}}">
<input type="hidden" id="hdn_class" value="{{$a->a_ic->fk_class}}">

<div class="row">
    <div class="col-12 card">
        <form action="#" method="POST" enctype="multipart/form-data">
            <fieldset>
                @csrf
                <div class="row card-body">
                    @if(Auth::user()->fk_role != 2)
                    <div class="col-12 col-sm-4">
                        <div class="form-group">
                            <label for="">Instituto</label>
                            <select name="fk_institute" id="fk_institute" class="form-control" required>
                                <option value="" disabled selected>Seleccione uno</option>
                                @foreach($ins as $i)
                                <option value="{{$i->te_inst->id}}">{{$i->te_inst->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @else
                    <input type="hidden" id="fk_institute" name="fk_institute" value="{{Auth::user()->fk_institute}}" required>
                    @endif
                    <div class="col-12 col-sm-4">
                        <div class="form-group">
                            <label for="">Turno</label>
                            <select name="shift" id="shift" class="form-control" required>
                                <option value="" disabled selected>Seleccione uno</option>
                                <option value="M">Matutino</option>
                                <option value="V">Vespertino</option>
                            </select>
                        </div>
                    </div>
                    @if(Auth::user()->fk_role != 3)
                    <div class="col-12 col-sm-4">
                        <div class="form-group">
                            <label for="">Docente</label>
                            <select name="fk_teacher" id="fk_teacher" class="form-control" required>
                                <option value="" disabled selected>Seleccione uno</option>
                                @foreach($d as $d)
                                <option value="{{$d->te_teach->id}}" data-institute="{{$d->fk_institute}}">{{$d->te_teach->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @else
                    <input type="hidden" id="fk_teacher" name="fk_teacher" value="{{Auth::user()->id}}" required>
                    @endif
                    <div class="col-12 col-sm-4">
                        <div class="form-group">
                            <label for="">Materia</label>
                            <select name="fk_class" id="fk_class" class="form-control" required>
                                <option value="" disabled selected>Seleccione uno</option>
                                @foreach($c as $c)
                                <option value="{{$c->ic_c->id}}" data-shift="{{$c->shift}}" data-teacher="{{$c->fk_teacher}}" data-institute="{{$c->fk_institute}}">{{$c->ic_c->classname}} {{$c->classgrade}}º {{$alphabet[$c->classgroup -1 ]}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="instruction">Instrucción</label>
                            <input type="text" name="instruction" id="instruction" class="form-control" placeholder="Instrucción" title="Instrucción" maxlength="250" value="{{$a->instruction}}" required>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="request">Descripción</label>
                            <textarea name="request" id="request" class="form-control" placeholder="Descripción" title="Descripción" rows="8" maxlength="2000" required>{{$a->request}}</textarea>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="startend">Vigencia de entrega</label>
                            <input type="text" name="startend" id="startend" class="dates form-control text-center" placeholder="Vigencia de entrega" title="Vigencia de entrega" value="{{$a->start}} - {{$a->end}}" required>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <input type="hidden" id="file_path" value="{{$a->file_request}}" >
                            <label for="file_request">Cargar archivo de actividad (zip, pdf)</label>
                            <label for="file_request" class="btn btn-secondary btn-block">
                                Cargar archivo
                                <input type="file" name="file_request" id="file_request">
                            </label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group text-right">
                            <a href="{{url('/activities')}}" class="btn btn-secondary">Volver</a>
                            <button class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>

<script src="{{asset('js/activities/activities.js')}}"></script>

@stop