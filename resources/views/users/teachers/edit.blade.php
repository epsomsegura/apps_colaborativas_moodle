@extends('layouts.app')

@section('title','Editar expediente')
@section('content')

<input type="hidden" id="mode" value="E">

<div class="row">
    <div class="card col-12">
        <form action="{{url('/users/teachers/'.Crypt::encrypt($u->id))}}" method="POST" enctype="multipart/form-data">
            <fieldset>
                @csrf
                @method('PATCH')

                @include('settings.root_institute_edit')

                <div id="accordion">
                    <!-- Datos del estudiante -->
                    <div class="card">
                        <div class="card-header" id="headingStudent">
                            <h5 class="mb-0">
                                <button type="button" class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseStudent" aria-expanded="true" aria-controls="collapseStudent">
                                    1. Datos del docente
                                </button>
                            </h5>
                        </div>
                        <div id="collapseStudent" class="collapse show" aria-labelledby="headingStudent" data-parent="#accordion">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <small><span class="text-danger">* Inicie preguntando el correo electrónico para buscar existencia del estudiante en el sistema</span></small>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name_teacher">Nombre completo</label>
                                            <input type="text" id="name_teacher" name="name[]" class="form-control" placeholder="Nombre completo" title="Nombre completo" maxlength="150" value="{{$u->te_teach->name}}" required autofocus>
                                        </div>
                                    </div>
                                    <input type="hidden" name="fk_role" value="5">
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="email_teacher">Correo electrónico</label>
                                            <div class="input-group">
                                                <input type="email" id="email_teacher" name="email[]" class="form-control" placeholder="Correo electrónico" title="Correo electrónico" maxlength="150" value="{{$u->te_teach->email}}" required>
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="button" id="btn_email_teacher"><i class="fas fa-search"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-8">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group" style="margin-bottom: 0.5rem !important;">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="chk_password_teacher">
                                                        <label class="form-check-label" for="chk_password_teacher">¿Cambiar contraseña?<label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="row" id="password_container_teacher"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <!-- Datos de turno, grado y grupo -->
                    <div class="card">
                        <div class="card-header" id="headingGradeGroup">
                            <h5 class="mb-0">
                                <button type="button" class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseGradeGroup" aria-expanded="false" aria-controls="collapseGradeGroup">
                                    2. Perfil académico
                                </button>
                            </h5>
                        </div>
                        <div id="collapseGradeGroup" class="collapse" aria-labelledby="headingGradeGroup" data-parent="#accordion">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12" id="suggestions">

                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="t_profile">Perfíl académico</label>
                                            <input type="hidden" name="fk_profile"  id="fk_profile" value="{{$u->fk_profile}}">
                                            <input type="text" id="profile" class="form-control" placeholder="Perfil acacémico" title="Perfil académico" value="{{$u->te_prof->profile}}" required>
                                        </div>
                                    </div>
                                    <div class="col-12" id="description_container" style="display:none;">
                                        <div class="form-group">
                                            <label for="classname">Descripción</label>
                                            <textarea name="description" id="description" class="form-control" rows="5" maxlength="250" placeholder="Descripción" title="Descripción">{{$u->te_prof->description}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12"><br></div>
                    <div class="col-12">
                        <div class="form-group text-right">
                            <a href="{{url('/users/teachers')}}" class="btn btn-secondary">Volver</a>
                            <button type="button" id="btn_save" class="btn btn-primary">Guardar</button>
                            <input type="submit" id="btn_send" value="" hidden>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>

<script src="{{asset('js/users/teachers_expedients.js')}}"></script>

@stop