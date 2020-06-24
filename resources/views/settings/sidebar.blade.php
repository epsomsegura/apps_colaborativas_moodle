<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link" href="{{url('/home')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>

                <!-- CONFIGURACIONES -->
                @if(in_array(Auth::user()->fk_role,[1,2]))
                <div class="sb-sidenav-menu-heading">Configuraciones</div>
                @endif
                @if(in_array(Auth::user()->fk_role,[2]))
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-school"></i></div>
                    Institución
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        @if(in_array(Auth::user()->fk_role,[2]))<a class="nav-link" href="{{url('/institutes/myInstitute')}}">Datos básicos</a>@endif
                    </nav>
                </div>
                @endif

                <!-- Subsección - CATÁLOGOS -->
                @if(in_array(Auth::user()->fk_role,[1,2]))
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseInstituto" aria-expanded="false" aria-controls="collapseInstituto">
                    <div class="sb-nav-link-icon"><i class="fas fa-th-list"></i></div>
                    Catálogos
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseInstituto" aria-labelledby="collapseInstituto" data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        @if(in_array(Auth::user()->fk_role,[1]))<a class="nav-link" href="{{url('/roles')}}">Roles</a>@endif
                        @if(in_array(Auth::user()->fk_role,[1,2]))<a class="nav-link" href="{{url('/users')}}">Usuarios</a>@endif
                        @if(in_array(Auth::user()->fk_role,[1]))<a class="nav-link" href="{{url('/education_level')}}">Niveles educativos</a>@endif
                        @if(in_array(Auth::user()->fk_role,[1]))<a class="nav-link" href="{{url('/institutes')}}">Institutos</a>@endif
                        @if(in_array(Auth::user()->fk_role,[1]))<a class="nav-link" href="{{url('/grades-groups')}}">Grados y grupos</a>@endif
                        @if(in_array(Auth::user()->fk_role,[1]))<a class="nav-link" href="{{url('/classes')}}">Materias</a>@endif
                        @if(in_array(Auth::user()->fk_role,[1]))<a class="nav-link" href="{{url('/profiles')}}">Perfiles académicos</a>@endif
                    </nav>
                </div>
                @endif



                @if(in_array(Auth::user()->fk_role,[1,2]))
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                    <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                    Administración
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                @endif
                <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                        @if(in_array(Auth::user()->fk_role,[1,2]))
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTeachersMenu" aria-expanded="false" aria-controls="collapseTeachersMenu">Docentes<div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div></a>
                        <div class="collapse" id="collapseTeachersMenu" aria-labelledby="collapseTeachersMenu" data-parent="#sidenavAccordionPages">
                            <nav class="sb-sidenav-menu-nested nav">
                                @if(in_array(Auth::user()->fk_role,[1,2]))<a class="nav-link" href="{{url('users/teachers')}}">Catálogo</a>@endif
                            </nav>
                        </div>
                        @endif
                        @if(in_array(Auth::user()->fk_role,[1,2]))
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStudentsMenu" aria-expanded="false" aria-controls="collapseStudentsMenu">Estudiantes<div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div></a>
                        <div class="collapse" id="collapseStudentsMenu" aria-labelledby="collapseStudentsMenu" data-parent="#sidenavAccordionPages">
                            <nav class="sb-sidenav-menu-nested nav">
                                @if(in_array(Auth::user()->fk_role,[1,2]))<a class="nav-link" href="{{url('/users/students')}}">Expedientes</a>@endif
                                @if(in_array(Auth::user()->fk_role,[1,2]))<a class="nav-link" href="register.html">Avances</a>@endif
                            </nav>
                        </div>
                        @endif
                        @if(in_array(Auth::user()->fk_role,[1,2]))
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseClassesMenu" aria-expanded="false" aria-controls="collapseClassesMenu">Materias<div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div></a>
                        <div class="collapse" id="collapseClassesMenu" aria-labelledby="collapseClassesMenu" data-parent="#sidenavAccordionPages">
                            <nav class="sb-sidenav-menu-nested nav">
                                @if(in_array(Auth::user()->fk_role,[1,2]))<a class="nav-link" href="{{url('/institute_classes')}}">Catálogo</a>@endif
                                @if(in_array(Auth::user()->fk_role,[1,2]))<a class="nav-link" href="{{url('/institute_classes/assignment')}}">Asignación</a>@endif
                                @if(in_array(Auth::user()->fk_role,[1,2]))<a class="nav-link" href="{{url('/institute_classes/students')}}">Estudiantes</a>@endif
                                @if(in_array(Auth::user()->fk_role,[1,2]))<a class="nav-link" href="{{url('/activities')}}">Actividades</a>@endif
                            </nav>
                        </div>
                        @endif
                    </nav>
                </div>


                <!-- Mis materias -->
                @if(in_array(Auth::user()->fk_role,[1,3,5]))
                <div class="sb-sidenav-menu-heading">Mis clases</div>
                @endif
                @if(in_array(Auth::user()->fk_role,[3]))
                <a class="nav-link" href="{{url('/institute_classes/teacher/'.Crypt::encrypt(Auth::id()))}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
                    Mis materias
                </a>
                @endif
                @if(in_array(Auth::user()->fk_role,[1,2,3,5]))
                <a class="nav-link" href="{{url('/activities/')}}">
                    <div class="sb-nav-link-icon"><i class="far fa-file"></i></div>
                    Mis actividades
                </a>
                @endif
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Sesión de:</div>
            {{Auth::user()->name}}
        </div>
    </nav>
</div>