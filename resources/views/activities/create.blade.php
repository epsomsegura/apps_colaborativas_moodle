@extends('layouts.app')

@section('title','Nueva actividad')
@section('content')

<div class="row">
    <div class="col-12 card">
        <form action="">
            <fieldset>
                <div class="row card-body">
                    <div class="col-12 col-sm-4">
                        <div class="form-group">
                            <label for="">Instituto</label>
                            <select name="" id="" class="form-control">
                                <option value="" disabled selected>Seleccione uno</option>
                                @foreach($i as $i)
                                <option value="{{$i->te_inst->id}}">{{$i->te_inst->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="form-group">
                            <label for="">Docente</label>
                            <select name="" id="" class="form-control">
                                <option value="" disabled selected>Seleccione uno</option>
                                @foreach($d as $d)
                                <option value="{{$d->te_teach->id}}" data-institute="{{$d->fk_institute}}">{{$d->te_teach->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="form-group">
                            <label for="">Materia</label>
                            <select name="" id="" class="form-control">
                                <option value="" disabled selected>Seleccione uno</option>
                                @foreach($c as $a)
                                <option value="{{$a->ic_c->id}}" data-teacher="{{$a->fk_teacher}}" data-institute="{{$a->fk_institute}}">{{$a->ic_c->classname}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>

@stop