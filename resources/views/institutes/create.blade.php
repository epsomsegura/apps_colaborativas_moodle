@extends('layouts.app')

@section('title','Nuevo instituto')
@section('content')


<div class="row">
    <div class="card col-12">
        <form action="{{url('/institutes/new')}}" method="POST">
            <fieldset>
                @csrf
                <div class="card-body row">
                    <div class="col-12 col-sm-8">
                        <div class="form-group">
                            <label for="name">Institución</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Nombre de la institución" title="Nombre de la institución" required maxlength="150" autofocus>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="form-group">
                            <label for="fk_education_level">Nivel educativo</label>
                            <select id="fk_education_level" name="fk_education_level" id="" class="form-control" title="Nivel educativo" required>
                                <option value="" disabled selected>Seleccione uno</option>
                                @foreach($el as $i)
                                <option value="{{$i->id}}">{{$i->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-sm-2">
                        <div class="form-group">
                            <label for="zipcode">C.P.</label>
                            <div class="input-group">
                                <input type="number" id="zipcode" name="zipcode" class="form-control" placeholder="00000" title="Código postal" min="1000" max="99999" required />
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" id="btn_zipcode"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-5">
                        <div class="form-group">
                            <label for="state">Estado</label>
                            <input type="text" id="state" name="state" class="form-control" placeholder="Estado" title="Estado" required maxlength="150" readonly>
                        </div>
                    </div>
                    <div class="col-12 col-sm-5">
                        <div class="form-group">
                            <label for="county">Municipio</label>
                            <input type="text" id="county" name="county" class="form-control" placeholder="Municipio" title="Municipio" required maxlength="150" readonly>
                        </div>
                    </div>
                    <div class="col-12 col-sm-5">
                        <div class="form-group">
                            <label for="suburb">Colonia</label>
                            <select name="suburb" id="suburb" class="form-control">
                                <option disabled selected>Seleccione uno</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-sm-7">
                        <div class="form-group">
                            <label for="address">Calle</label>
                            <input type="text" id="address" name="address" class="form-control" placeholder="Calle" title="Calle" required maxlength="250">
                        </div>
                    </div>

                    <div class="col-12 col-sm-4">
                        <div class="form-group">
                            <label for="phone">Teléfono</label>
                            <input type="text" id="phone" name="phone" class="form-control" placeholder="Teléfono" title="Teléfono" maxlength="13">
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="form-group">
                            <label for="email">Correo electrónico</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Correo electrónico" title="Correo electrónico" maxlength="50">
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="form-group">
                            <label for="institute_id">Clave</label>
                            <input type="text" id="institute_id" name="institute_id" class="form-control" placeholder="Clave" title="Clave" maxlength="30">
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group text-right">
                            <a href="{{url('/institutes')}}" class="btn btn-secondary">Volver</a>
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