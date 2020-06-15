@extends('layouts.app')

@section('title','Grados y grupos')
@section('content')

<input type="hidden" id="mode" value="E">
<input type="hidden" id="grade_val" value="">
<input type="hidden" id="group_class_val" value="">
<input type="hidden" id="hdn_shift" value="">

<div class="row">
    <div class="col-12 card">
        <form id="frm_grados_grupos" action="#" method="POST">
            <fieldset>
                @csrf
                @method('PATCH')
                <div class="row card-body">
                    @if(Auth::user()->fk_role == 1)
                    <div class="col-12 col-sm-4">
                        <div class="form-group">
                            <label for="state">Estados</label>
                            <select class="form-control" id="state" {{((Auth::user()->fk_role==1) ? 'autofocus' : '')}}>
                                <option value="" disabled selected>Seleccione uno</option>
                                @foreach($s as $s)
                                <option value="{{$s->id}}">{{$s->estado}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="form-group">
                            <label for="county">Municipios</label>
                            <select class="form-control" id="county">
                                <option value="" disabled selected>Seleccione uno</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="form-group">
                            <label for="fk_institute">Instituto</label>
                            <select id="fk_institute" class="form-control" required>
                                <option value="" disabled selected>Seleccione uno</option>
                            </select>
                        </div>
                    </div>
                    @else
                    <input type="hidden" id="fk_institute" value="{{$id}}">
                    @endif

                    <div class="col-12 col-sm-4">
                        <div class="form-group">
                            <label for="shift">Turno</label>
                            <select name="shift" id="shift" class="form-control" required {{((Auth::user()->fk_role==2) ? 'autofocus' : '')}}>
                                <option value="" disabled selected>Seleccione uno</option>
                                <option value="M">Matutino</option>
                                <option value="V">Vespertino</option>
                                <option value="A">Ambos</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-sm-3">
                        <div class="form-group">
                            <label for="grades">Grados</label>
                            <input type="number" id="grades" name="grades" class="form-control text-center" placeholder="Grados" title="Grados" min="1" max="6" required>
                        </div>
                    </div>
                    <div class="col-12 col-sm-3">
                        <div class="form-group">
                            <label for="groups">Grupos (por grado)</label>
                            <input type="number" id="groups" name="groups" class="form-control text-center" placeholder="Grupos" title="Grupos" min="1" max="20" required>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group text-right">
                            <button type="button" id="btn_save" class="btn btn-primary">Guardar</button>
                            <input type="submit" id="btn_send" value="" hidden>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>

<script src="{{asset('js/grades_groups/grades_groups.js')}}"></script>

@stop