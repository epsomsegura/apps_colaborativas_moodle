@extends('layouts.app')

@section('title','Nueva materia del instituto')
@section('content')

<input type="hidden" id="mode" value="C">

<div class="row">
    <div class="col-12 card">
        <form action="{{url('/institute_classes/new')}}" method="POST" enctype="multipart/form-data">
            <fieldset>
                @csrf
                @include('settings.root_institute_create')
                <div class="card-body row">
                    <div class="col-12">
                        <small><span class="text-danger text-justify">*Por favor haga clic en el <strong>botón de la materia sugerida</strong>, de lo contrario escriba el nombre completo de la materia y haga clic en el <strong>botón Guardar materia</strong></span></small>
                    </div>
                    <div class="col-12" id="suggestions">

                    </div>
                    <div class="col-12 col-sm-12">
                        <div class="form-group">
                            <label for="classname">Materia</label>
                            <input type="hidden" name="fk_class" id="fk_class">
                            <input type="text" id="classname" class="form-control" placeholder="Materia" title="Materia" required>
                        </div>
                    </div>
                    <div class="col-12" id="description_container" style="display:none;">
                        <div class="form-group">
                            <label for="classname">Descripción</label>
                            <textarea name="description" id="description" class="form-control" rows="5" maxlength="250" placeholder="Descripción" title="Descripción"></textarea>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="form-group">
                            <label for="shift" id="lbl_shift">Turno</label>
                            <div>
                                @if(Auth::user()->fk_role == 2)
                                @if($institute->shift == 'A')
                                <select name="shift" id="shift" class="form-control">
                                    <option value="" disabled selected>Seleccione uno</option>
                                    <option value="M">Matutino</option>
                                    <option value="V">Vespertino</option>
                                </select>
                                @else
                                @if($institute->shift == 'M') <input type="text" id="txt_shift" class="form-control" value="Matutino" readonly>@endif
                                @if($institute->shift == 'V') <input type="text" id="txt_shift" class="form-control" value="Vespertino" readonly>@endif
                                <input type="hidden" name="shift" id="shift" class="form-control" value="{{$institute->shift}}" readonly>
                                @endif
                                @elseif(Auth::user()->fk_role == 1)
                                <input type="text" id="txt_shift" class="form-control" placeholder="Turno" readonly>
                                <input type="hidden" name="shift" id="shift" class="form-control" value="" readonly>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-3">
                        <div class="form-group" id="gradesChecklist"></div>
                    </div>
                    <div class="col-12 col-sm-3">
                        <div class="form-group" id="groupsChecklist"></div>
                    </div>
                    <div class="col-12">
                        <div class="form-group text-right">
                            <a href="{{url('/institute_classes')}}" class="btn btn-secondary">Volver</a>
                            <button class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>

<script src="{{asset('/js/instituteclasses/instituteclasses.js')}}"></script>

@stop