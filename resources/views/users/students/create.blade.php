@extends('layouts.app')

@section('title','Nuevo expediente')
@section('content')

<input type="hidden" id="mode" value="C">

<div class="row">
    <div class="card col-12">
        <form action="{{url('/users/students/new')}}" method="POST" enctype="multipart/form-data">
            <fieldset>
                @csrf

                @include('settings.root_institute_create')

                <div id="accordion">
                    <!-- Datos del estudiante -->
                    <div class="card">
                        <div class="card-header" id="headingStudent">
                            <h5 class="mb-0">
                                <button type="button" class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseStudent" aria-expanded="true" aria-controls="collapseStudent">
                                    1. Datos del estudiante
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
                                            <label for="name_student">Nombre completo</label>
                                            <input type="text" id="name_student" name="name[]" class="form-control" placeholder="Nombre completo" title="Nombre completo" maxlength="150" required autofocus>
                                        </div>
                                    </div>
                                    <input type="hidden" name="fk_role" value="5">
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="email_student">Correo electrónico</label>
                                            <div class="input-group">
                                                <input type="email" id="email_student" name="email[]" class="form-control" placeholder="Correo electrónico" title="Correo electrónico" maxlength="150" required>
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="button" id="btn_email_student"><i class="fas fa-search"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-8">
                                        <div class="row">
                                            <div class="col-12 col-sm-5">
                                                <div class="form-group">
                                                    <label for="password_student">Contraseña</label>
                                                    <input type="password" id="password_student" name="password[]" class="form-control" placeholder="Contraseña" title="Contraseña" required>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-5">
                                                <div class="form-group">
                                                    <label for="password2_student">Repita la contraseña</label>
                                                    <input type="password" id="password2_student" name="password2[]" class="form-control" placeholder="Repita la contraseña" title="Repita la contraseña" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Datos del padre o tutor -->
                    <div class="card">
                        <div class="card-header" id="headingParents">
                            <h5 class="mb-0">
                                <button type="button" class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseParents" aria-expanded="false" aria-controls="collapseParents">
                                    2. Datos del padre o tutor
                                </button>
                            </h5>
                        </div>
                        <div id="collapseParents" class="collapse" aria-labelledby="headingParents" data-parent="#accordion">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <small><span class="text-danger">* Inicie preguntando el correo electrónico para buscar existencia del padre en el sistema</span></small>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name_parent">Nombre completo</label>
                                            <input type="text" id="name_parent" name="name[]" class="form-control" placeholder="Nombre completo" title="Nombre completo" maxlength="150" required autofocus>
                                        </div>
                                    </div>
                                    <input type="hidden" name="fk_role" value="5">
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="email_parent">Correo electrónico</label>
                                            <div class="input-group">
                                                <input type="email" id="email_parent" name="email[]" class="form-control" placeholder="Correo electrónico" title="Correo electrónico" maxlength="150" required>
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="button" id="btn_email_parent"><i class="fas fa-search"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-8" id="pwds_container">
                                        <div class="row">
                                            <div class="col-12 col-sm-5">
                                                <div class="form-group">
                                                    <label for="password_parent">Contraseña</label>
                                                    <input type="password" id="password_parent" name="password[]" class="form-control" placeholder="Contraseña" title="Contraseña" required>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-5">
                                                <div class="form-group">
                                                    <label for="password2_parent">Repita la contraseña</label>
                                                    <input type="password" id="password2__parent" name="password2[]" class="form-control" placeholder="Repita la contraseña" title="Repita la contraseña" required>
                                                </div>
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
                                    3. Turno, grado y grupo
                                </button>
                            </h5>
                        </div>
                        <div id="collapseGradeGroup" class="collapse" aria-labelledby="headingGradeGroup" data-parent="#accordion">
                            <div class="card-body">
                                <div class="row">
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
                                        <div class="form-group">
                                            <label for="grade">Grado</label>
                                            <select name="grade" id="grade" class="form-control" required>
                                                <option value="" disabled selected>Seleccione uno</option>
                                                @if(Auth::user()->fk_role == 2)
                                                @for($i=0;$i<$institute->grades;$i++)
                                                    <option value="{{($i+1)}}">{{($i+1)}}</option>
                                                    @endfor
                                                    @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <label for="group_class">Grupo</label>
                                        <select name="group_class" id="group_class" class="form-control">
                                            <option value="" disabled selected>Seleccione uno</option>
                                            @if(Auth::user()->fk_role == 2)
                                            @foreach($groups as $k=>$g)
                                            <option value="{{$k+1}}">{{$g}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12"><br></div>
                    <div class="col-12">
                        <div class="form-group text-right">
                            <a href="{{url('/users/students')}}" class="btn btn-secondary">Volver</a>
                            <button type="button" id="btn_save" class="btn btn-primary">Guardar</button>
                            <input type="submit" id="btn_send" value="" hidden>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>

<script src="{{asset('js/users/students_expedients.js')}}"></script>

@stop