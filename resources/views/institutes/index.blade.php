@extends('layouts.app')

@section('title','Institutos')
@section('content')

<div class="row">
    <div class="col-12 text-right">
        <div class="form-group">
            <a href="{{url('institutes/new')}}" class="btn btn-primary">Nuevo instituto</a>
        </div>
    </div>
    <div class="col-12">
        <table class="table table-condensed table-hover">
            <thead>
                <tr>
                    <th>Instituto</th>
                    <th>Nivel educativo</th>
                    <th>Dirección</th>
                    <th>C.P.</th>
                    <th>Colonia</th>
                    <th>Municipio</th>
                    <th>Estado</th>
                    <th>Clave</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($institutes as $i)
                <tr>
                    <td>{{$i->name}}</td>
                    <td>{{$i->n_e->name}}</td>
                    <td>{{$i->address}}</td>
                    <td>{{$i->zipcode}}</td>
                    <td>{{$i->suburb}}</td>
                    <td>{{$i->county}}</td>
                    <td>{{$i->state}}</td>
                    <td>{{$i->institute_id}}</td>
                    <td class="text-center">
                        <a href="{{url('/institutes/'.Crypt::encrypt($i->id))}}" class="btn_edit text-primary" title="Editar"><i class="fas fa-edit"></i></a>
                        <a href="#" class="btn_delete text-danger" data-id="{{Crypt::encrypt($i->id)}}" title="Eliminar" data-target="#mdl_delete" data-toggle="modal"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@include('institutes.delete')
</div>

<script src="{{asset('js/institutes/institutes.js')}}"></script>
@stop