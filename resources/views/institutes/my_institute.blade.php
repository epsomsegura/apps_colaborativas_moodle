@extends('layouts.app')

@section('title','Mi instituto')
@section('content')


<div class="row">
    <div class="card col-12">
        <form action="{{url('/institutes/myInstitute')}}" method="POST">
            <fieldset>
                @csrf
                @method('PATCH')
                <div class="card-body row">
                    <div class="col-12 col-sm-8">
                        <div class="form-group">
                            <label for="name">Institución</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Nombre de la institución" title="Nombre de la institución" required maxlength="150" value="{{$i->name}}" autofocus>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <label for="">Nivel educativo</label>
                        <input type="text" class="form-control" value="{{$i->n_e->name}}" readonly>
                    </div>
                    <div class="col-12 col-sm-2">
                        <div class="form-group">
                            <label for="zipcode">C.P.</label>
                            <div class="input-group">
                                <input type="number" id="zipcode" name="zipcode" class="form-control" placeholder="00000" title="Código postal" min="1000" max="99999" required value="{{$i->zipcode}}"/>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" id="btn_zipcode"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-5">
                        <div class="form-group">
                            <label for="state">Estado</label>
                            <input type="text" id="state" name="state" class="form-control" placeholder="Estado" title="Estado" required maxlength="150" value="{{$i->state}}" readonly>
                        </div>
                    </div>
                    <div class="col-12 col-sm-5">
                        <div class="form-group">
                            <label for="county">Municipio</label>
                            <input type="text" id="county" name="county" class="form-control" placeholder="Municipio" title="Municipio" required maxlength="150" value="{{$i->county}}" readonly>
                        </div>
                    </div>
                    <div class="col-12 col-sm-5">
                        <div class="form-group">
                            <label for="suburb">Colonia</label>
                            <select name="suburb" id="suburb" class="form-control">
                                <option disabled selected>Seleccione uno</option>
                                @foreach($suburb as $s)
                                @if($s->asentamiento == $i->suburb)
                                <option value="{{$s->asentamiento}}" selected>{{$s->asentamiento}}</option>
                                @else
                                <option value="{{$s->asentamiento}}">{{$s->asentamiento}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-sm-7">
                        <div class="form-group">
                            <label for="address">Calle</label>
                            <input type="text" id="address" name="address" class="form-control" placeholder="Calle" title="Calle" value="{{$i->address}}" required maxlength="250">
                        </div>
                    </div>

                    <div class="col-12 col-sm-4">
                        <div class="form-group">
                            <label for="phone">Teléfono</label>
                            <input type="text" id="phone" name="phone" class="form-control" placeholder="Teléfono" title="Teléfono" value="{{$i->phone}}" maxlength="13">
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="form-group">
                            <label for="email">Correo electrónico</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Correo electrónico" title="Correo electrónico" value="{{$i->email}}" maxlength="50">
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="form-group">
                            <label for="institute_id">Clave</label>
                            <input type="text" id="institute_id" name="institute_id" class="form-control" placeholder="Clave" title="Clave" value="{{$i->institute_id}}" maxlength="30">
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group text-right">
                            <button class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>

<script src="{{asset('js/institutes/institutes.js')}}"></script>

@stop