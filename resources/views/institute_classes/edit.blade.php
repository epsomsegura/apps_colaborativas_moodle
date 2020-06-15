@extends('layouts.app')

@section('title','Editar materia del instituto')
@section('content')

<input type="hidden" id="mode" value="E">

<div class="row">
    <div class="col-12 card">
        <form action="{{url('/institute_classes/'.Crypt::encrypt($u->id))}}" method="POST" enctype="multipart/form-data">
            <fieldset>
                @csrf
                @method('PATCH')
                @include('settings.root_institute_edit')
                <div class="card-body row">
                    <div class="col-12">
                        <small><span class="text-danger text-justify">*Por favor haga clic en el <strong>botón de la materia sugerida</strong>, de lo contrario escriba el nombre completo de la materia y haga clic en el <strong>botón Guardar materia</strong></span></small>
                    </div>
                    <div class="col-12" id="suggestions">

                    </div>
                    <div class="col-12 col-sm-12">
                        <div class="form-group">
                            <label for="classname">Materia</label>
                            <input type="hidden" name="fk_class" id="fk_class" value="{{$u->ic_c->id}}">
                            <input type="text" id="classname" class="form-control" placeholder="Materia" title="Materia" value="{{$u->ic_c->classname}}" readonly required>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="form-group">
                            <label for="shift" id="lbl_shift">Turno</label>
                            <div>
                                @if(Auth::user()->fk_role == 2)
                                @if($institute->shift == 'A')
                                <select name="shift" id="shift" class="form-control">
                                    <option value="" disabled>Seleccione uno</option>
                                    @if($u->shift == 'M')<option value="M" selected>Matutino</option>@else<option value="M">Matutino</option>@endif
                                    @if($u->shift == 'V')<option value="V" selected>Vespertino</option>@else<option value="V">Vespertino</option>@endif
                                </select>
                                @else
                                @if($institute->shift == 'M')<input type="text" id="t_shift" class="form-control" value="Matutino" readonly>@endif
                                @if($institute->shift == 'V')<input type="text" id="t_shift" class="form-control" value="Vespertino" readonly>@endif
                                <input type="hidden" name="shift" id="shift" class="form-control" value="{{$institute->shift}}" readonly>
                                @endif
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