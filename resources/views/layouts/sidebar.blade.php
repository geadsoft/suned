<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="index" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ URL::asset('assets/images/power.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('assets/images/ontime.png') }}" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="index" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ URL::asset('assets/images/power.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('assets/images/sams-ueas.png') }}" alt="" height="40">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-default" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>


    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                @can('Panel')
                <li class="menu-title"><span>@lang('translation.home')</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="/">
                        <i class="las la-tachometer-alt fs-20"></i> <span>@lang('translation.dashboards')</span>
                    </a>
                </li>
                @endif
                @can('Graficos')
                <li class="nav-item">
                    <a class="nav-link menu-link" href="/report/statistical-graphs">
                        <i class="las la-chart-pie fs-20"></i> <span>Gráficos</span>
                    </a>
                </li>
                @endcan
                @can('Calendario')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('calendario_view') }}">
                        <i class="las la-calendar-day fs-20"></i> <span>Calendario</span>
                    </a>
                </li>
                @endcan
                @can('Asignaturas')
                <li class="nav-item">
                    <a class="nav-link menu-link" href="/student/subject">
                        <i class="las la-school fs-20"></i> <span>Asignaturas</span>
                    </a>
                </li>
                @endcan
                <li class="menu-title"><i class="ri-more-fill"></i> <span>MODULOS</span></li>
                @can('Academico')
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#academico" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="academico">
                        <i class=" las la-graduation-cap fs-20"></i><span>Academico</span>
                    </a>
                    <div class="collapse menu-dropdown" id="academico">
                        <ul class="nav nav-sm flex-column">
                            @can('Ficha Estudiante')
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#sidebarPerson" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarPerson">
                                    <i class="las la-user-check fs-20"></i> <span>Estudiantes</span>
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarPerson">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="/academic/students" class="nav-link" role="button">Fichas</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="/academic/representatives" class="nav-link" role="button">@lang('translation.representatives')
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            @endcan
                            @can('Matricula')
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="/academic/tuition">
                                    <i class="las la-address-card fs-20"></i> <span>@lang('translation.tuition')</span>
                                </a>
                            </li>
                            @endcan
                            @can('Estudiante')
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="/academic/information-student">Estudiantes</a>
                            </li>
                            @endcan
                            @can('Pase Modalidad')
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="/academic/pass-course">Pase de Modalidad</a>
                            </li>
                            @endcan
                            @can('Asistencia')
                            <li class="nav-item">
                                <a href="#sidebarAsistencia" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="asistencia" data-key="t-profile">Asistencias</a>
                                <div class="menu-dropdown collapse" id="sidebarAsistencia" style="">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link menu-link" href="/academic/daily-attendance">
                                                </i>Asistencia Diaria<span></span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link menu-link" href="/academic/justify-faults">
                                                </i>Justificar Faltas<span></span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            @endcan
                            @can('Calificaciones')
                            <li class="nav-item">
                                <a href="#sidebarCalifica" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="calificacion" data-key="t-profile">Calificaciones</a>
                                <div class="menu-dropdown collapse" id="sidebarCalifica" style="">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link menu-link" href="/academic/qualify-activity">
                                                </i>Calificar Actividades<span></span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link menu-link" href="/academic/qualify-exams">
                                                </i>Calificar Examenes<span></span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link menu-link" href="/academic/qualify-suppletory">
                                                </i>Calificar Supletorios<span></span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link menu-link" href="/academic/qualify-suppletory">
                                                </i>Calificar Conducta<span></span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endcan
                @can('Sede Educativa')
                <!--Sedes-->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sede" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sede">
                        <i class="las la-school fs-20"></i> <span>Sede Educativa</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sede">
                        <ul class="nav nav-sm flex-column">
                            @can('Sede')
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#sidebarsede" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarsede">
                                    <span>Sede</span>
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarsede">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link menu-link" href="/headquarters/headquarters-add">
                                                <span>@lang('translation.headquarter')</span>
                                            </a>    
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link menu-link" href="/headquarters/educational-services">
                                                <span>@lang('translation.services')</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link menu-link" href="/headquarters/pension">
                                                <span>@lang('translation.charges')</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            @endcan
                            @can('Administrar Sede')
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#administracion" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarsede">
                                    <span>Administración</span>
                                </a>
                                <div class="collapse menu-dropdown" id="administracion">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link menu-link" href="/academic/periods">
                                                <i class="las la-calendar fs-20"></i> <span>Periodos Lectivos</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link menu-link" href="/academic/course">
                                                <i class="las la-chalkboard fs-20"></i> <span>@lang('translation.course')</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link menu-link" href="/headquarters/subjects">
                                                <i class="las la-school fs-20"></i> <span>Asignaturas</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link menu-link" href="/headquarters/schedules">
                                                <i class="las la-stopwatch fs-20"></i> <span>Horario de Clase</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link menu-link" href="/headquarters/staff">
                                                <i class="las la-address-card fs-20"></i> <span>Personal</span>
                                            </a>    
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            @endcan
                            @can('Sistema Acádemico')
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="/headquarters/educational-system">Sistema Acádemico</a>
                            </li>
                            @endcan                        
                        </ul>
                    <div>
                </li>
                @endcan
                @can('Financiero')
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#financiero" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sede">
                        <i class="las la-donate fs-20"></i> <span>Financiero</span>
                    </a>
                    <div class="collapse menu-dropdown" id="financiero">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#cobranzas" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarsede">
                                    <i class="ri-menu-add-line fs-20"></i> <span>Cobranzas</span>
                                </a>
                                <div class="collapse menu-dropdown" id="cobranzas">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link menu-link" href="/financial/encashment">
                                                <span>Registrar Cobro</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link menu-link" href="/financial/account-status">
                                                <span>@lang('translation.statement-of-account')</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link menu-link" href="/financial/list-income">
                                                <span>@lang('translation.list-income')</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#comprobantes" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarsede">
                                    <i class="mdi mdi-*-* mdi-gesture-double-tap fs-20"></i> <span>Doc. Electronicos</span>
                                </a>
                                <div class="collapse menu-dropdown" id="comprobantes">
                                    <ul class="nav nav-sm flex-column">
                                        <a class="nav-link menu-link" href="#Factura" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarsede">
                                            <i class="mdi mdi-*-* mdi-filter-variant-plus fs-20"></i> <span>Facturas</span>
                                        </a>
                                        <div class="collapse menu-dropdown" id="Factura">
                                            <ul class="nav nav-sm flex-column">
                                                <li class="nav-item">
                                                    <a class="nav-link menu-link" href="/sri/create-invoice">
                                                        <span>Nuevo</span>
                                                    </a>    
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link menu-link" href="/sri/invoices/FE">
                                                        <span>Todos</span>
                                                    </a>    
                                                </li>
                                            </ul>
                                        </div>
                                        <a class="nav-link menu-link" href="#NCredito" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarsede">
                                            <i class="mdi mdi-*-* mdi-filter-variant-minus fs-20"></i> <span>Notas de Créditos</span>
                                        </a>
                                        <div class="collapse menu-dropdown" id="NCredito">
                                            <ul class="nav nav-sm flex-column">
                                                <li class="nav-item">
                                                    <a class="nav-link menu-link" href="/sri/create-credits">
                                                        <span>Nuevo</span>
                                                    </a>    
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link menu-link" href="/sri/invoices/NE">
                                                        <span>Todos</span>
                                                    </a>    
                                                </li>
                                            </ul>
                                        </div>
                                    </ul>
                                </div>

                            </li>
                        </ul>
                    </div>
                </li>
                @endcan
                @can('Inventario')
                <!--Inventario-->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#inventario" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sede">
                        <i class="las la-clipboard-check fs-20"></i> <span>Inventario</span>
                    </a>
                    <div class="collapse menu-dropdown" id="inventario">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#productos" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarsede">
                                    <i class="ri-shopping-cart-2-line fs-20"></i> <span>Productos</span>
                                </a>
                                <div class="collapse menu-dropdown" id="productos">
                                    <ul class="nav nav-sm flex-column">
                                        <a class="nav-link menu-link" href="#catalogo" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarsede">
                                            <i class="ri-price-tag-3-line fs-20"></i> <span>Catálogo</span>
                                        </a>
                                        <div class="collapse menu-dropdown" id="catalogo">
                                            <ul class="nav nav-sm flex-column">
                                                <li class="nav-item">
                                                    <a class="nav-link menu-link" href="/inventary/products">
                                                        <span>Registrar</span>
                                                    </a>    
                                                </li>

                                            </ul>
                                        </div>
                                        <a class="nav-link menu-link" href="#movimientos" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarsede">
                                            <i class="mdi mdi-*-* mdi-filter-variant-plus fs-20"></i> <span>Movimientos</span>
                                        </a>
                                        <div class="collapse menu-dropdown" id="movimientos">
                                            <ul class="nav nav-sm flex-column">
                                                <li class="nav-item">
                                                    <a class="nav-link menu-link" href="/inventary/register">
                                                        <span>Registrar</span>
                                                    </a>    
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link menu-link" href="/inventary/movements">
                                                        <span>Consultar</span>
                                                    </a>    
                                                </li>
                                            </ul>
                                        </div>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="/inventary/stock">
                                    <i class=" las la-tags fs-20"></i><span>Stock</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endcan
                @can('Secretaria')
                <!--Secretaria-->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#secretaria" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sede">
                        <i class="las la-laptop fs-20"></i> <span>Secretaria</span>
                    </a>
                    <div class="collapse menu-dropdown" id="secretaria">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#certificado" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarsede">
                                    <i class="las la-file-alt fs-20"></i> <span>Certf. & Solicitudes</span>
                                </a>
                                <div class="collapse menu-dropdown" id="certificado">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link menu-link" href="/secretary/certificate">
                                                <span>Certificados</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link menu-link" href="/secretary/requests">
                                                <span>Solicitudes</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#calificaciones" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarsede">
                                    <i class="las la-medal fs-20"></i> <span>Calificaciones</span>
                                </a>
                                <div class="collapse menu-dropdown" id="calificaciones">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link menu-link" href="/secretary/promotion">
                                                <span>Certf. de Promoción</span>
                                            </a>    
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link menu-link" href="/secretary/ratings">
                                                <span>Calificaciones</span>
                                            </a>    
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#documentacion" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarsede">
                                    <i class="ri-book-3-line fs-20"></i> <span>Documentación</span>
                                </a>
                                <div class="collapse menu-dropdown" id="documentacion">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link menu-link" href="/secretary/documentation">
                                                <span>Registro</span>
                                            </a>    
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link menu-link" href="/secretary/report-cas">
                                                <span>Ingreso de CAS</span>
                                            </a>    
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link menu-link" href="/secretary/titles-file">
                                                <span>Títulos y Actas</span>
                                            </a>    
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
                @endcan

                @can('Horario Escolar')
                <li class="nav-item">
                    <a class="nav-link menu-link" href="/student/school-schedule">
                        <i class="las la-calendar-check fs-20"></i>Horario Escolar</span>
                    </a>
                </li>
                @endcan

                @can('Actividades')
                <li class="nav-item">
                    <a class="nav-link menu-link" href="/activities/activity">
                        <i class="las la-calendar-check fs-20"></i>Actividades</span>
                    </a>
                </li>
                @endcan
                @can('Tareas')
                <li class="nav-item">
                    <a class="nav-link menu-link" href="/student/activities">
                        <i class="ri-honour-line fs-20"></i>Actividades</span>
                    </a>
                </li>
                @endcan
                @can('Mis Recursos')
                <li class="nav-item">
                    <a class="nav-link menu-link" href="/student/resources">
                        <i class="ri-folder-open-line fs-20"></i>Mis Recursos</span>
                    </a>
                </li>
                @endcan
                @can('Clases Virtuales')
                <li class="nav-item">
                    <!--<a class="nav-link menu-link" href="/activities/virtual-classes">
                        <i class="las la-calendar-check fs-20"></i>Clases Virtuales</span>
                    </a>-->
                    <a class="nav-link menu-link" href="#clase" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="clase">
                        <i class="las la-video fs-20"></i><span>Clases Virtuales</span>
                    </a>
                    @can('Registrar Clase Virtual')
                    <div class="collapse menu-dropdown" id="clase">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="/activities/virtual-classes">
                                    </i>Registrar Clase Virtual<span></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    @endcan
                    @can('Iniciar Clase Virtual')
                    <div class="collapse menu-dropdown" id="clase">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="/virtual-classes/join">
                                    </i>Iniciar Clase Virtual<span></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    @endcan
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#faltas" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="faltas">
                        <i class="las la-tasks fs-20"></i><span>Justificativo de Faltas</span>
                    </a>
                    <div class="collapse menu-dropdown" id="faltas">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#">
                                    </i>Justificar<span></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endcan
                @can('Eventos Comunicados')
                <li class="nav-item">
                    <a class="nav-link menu-link" href="/academic/calendario">
                        <i class="las la-calendar-alt fs-20"></i>Eventos / Comunicados</span>
                    </a>
                </li>
                @endcan
                @can('Recursos')
                <li class="nav-item">
                    <a class="nav-link menu-link" href="/subject/resources">
                        <i class="ri-folder-open-line fs-20"></i>Recursos</span>
                    </a>
                </li>
                @endcan                
                @can('Personalizar')
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#personalizar" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="personalizar">
                        <i class="las la-tools fs-20"></i><span>Personalizar</span>
                    </a>
                    <div class="collapse menu-dropdown" id="personalizar">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="/subjects/personalize">
                                    </i>Asignaturas<span></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endcan
                @can('Mensajeria')
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#mensajeria" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="mensajeria">
                        <i class="las la-sms fs-20"></i><span>Mensajeria</span>
                    </a>
                    <div class="collapse menu-dropdown" id="mensajeria">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="/academic/tuition">
                                    </i>Bandeja de Entrada<span></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endcan
                @can('Examenes')
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#examen" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="examen">
                        <i class="las la-paste fs-20"></i><span>Exámenes</span>
                    </a>
                    <div class="collapse menu-dropdown" id="examen">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="/activities/exams">
                                    </i>Exámenes<span></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="/activities/suppletory">
                                    </i>Supletorios<span></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endcan
                @can('Reportes')
                <!--Consultas-->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#consultas" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sede">
                        <i class="las la-print fs-20"></i> <span>Reportes</span>
                    </a>
                    <div class="collapse menu-dropdown" id="consultas">
                        <ul class="nav nav-sm flex-column">
                            @can('Reporte Academico')
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#reportfinanciero" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="reportfinanciero">
                                    <i class="las la-graduation-cap fs-20"></i> <span>Academicos</span>
                                </a>
                                <div class="collapse menu-dropdown" id="reportfinanciero">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link menu-link" href="">
                                                <span>Documentación</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link menu-link" href="">
                                                <span>Calificaciones</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            @endcan
                            @can('Reporte Financiero')
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#sidebarreport" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarreport">
                                    <i class="las la-file-invoice-dollar fs-20"></i> <span>Financieros</span>
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarreport">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link menu-link" href="/report/box-balance">
                                                <span>@lang('translation.cash-receipt')</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link menu-link" href="/report/daily-charges">
                                                <span>@lang('translation.daily-cobros')</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link menu-link" href="/report/debt-analysis">
                                                <span>@lang('translation.debt-analysis')</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link menu-link" href="/report/generic-reports">
                                                <span>@lang('translation.generic')</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            @endcan
                            @can('Reporte Inventario')
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#sidebarproduct" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarreport">
                                    <i class="las la-clipboard-list fs-20"></i> <span>Inventario</span>
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarproduct">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link menu-link" href="/inventary/detail-movements">
                                                <span>Detalle de Movimientos</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link menu-link" href="/inventary/detail-products">
                                                <span>Detalle de Productos</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link menu-link" href="/report/utility">
                                                <span>Informe de Utilidades</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link menu-link" href="/report/sold-products">
                                                <span>Productos mas Vendidos</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            @endcan
                            @can('Reportes Cursos')
                            <li class="nav-item">
                                <a href="#cursos" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="cursos" data-key="t-profile">Cursos</a>
                                <div class="menu-dropdown collapse" id="cursos" style="">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="pages-profile.html" class="nav-link" data-key="t-simple-page">Asignaturas Parcial</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="pages-profile-settings.html" class="nav-link" data-key="t-settings">Asignaturas Trimestral</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="pages-profile.html" class="nav-link" data-key="t-simple-page">Estudiante Parcial</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="pages-profile-settings.html" class="nav-link" data-key="t-settings">Estudiante Trimestral</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="pages-profile-settings.html" class="nav-link" data-key="t-settings">Estudiante Total</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="pages-profile-settings.html" class="nav-link" data-key="t-settings">Conducta</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            @endcan
                            @can('Reportes Calificaciones')
                            <li class="nav-item">
                                <a href="#calificacion" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="calificacion" data-key="t-profile">Calificaciones</a>
                                <div class="menu-dropdown collapse" id="calificacion" style="">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="/report/total-rating" class="nav-link" data-key="t-simple-page">Totales</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="/report/detailed-rating" class="nav-link" data-key="t-settings">Detalladas</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="/report/exams-qualify" class="nav-link" data-key="t-settings">Examenes</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="/report/exams-qualify" class="nav-link" data-key="t-settings">Finales</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            @endcan
                            @can('Reportes Docentes')
                            <li class="nav-item">
                                <a href="#reportdocente" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="reportdocente" data-key="t-profile">Docente</a>
                                <div class="menu-dropdown collapse" id="reportdocente" style="">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="/report/partial-teacher" class="nav-link" data-key="t-team">Informe Parcial</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="/report/quarterly-teacher" class="nav-link" data-key="t-timeline">Informe Trimestral</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="" class="nav-link" data-key="t-faqs">Reporte de Asistencia</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="" class="nav-link" data-key="t-pricing">Reporte Anual</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endcan
                @can('Sistemas')
                <!--Sistemas-->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sistemas" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sede">
                        <i class="las la-terminal fs-20"></i> <span>Sistemas</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sistemas">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#config" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarreport">
                                    <i class="ri-tools-fill fs-20"></i> <span>Configuración</span>
                                </a>
                                <div class="collapse menu-dropdown" id="config">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link menu-link" href="/config/generality">
                                                <span>@lang('translation.generality')</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#sidebaruser" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarreport">
                                    <i class="las la-user-check fs-20"></i> <span>Gestión de Accesos</span>
                                </a>
                                <div class="collapse menu-dropdown" id="sidebaruser">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link menu-link" href="/config/permissions">
                                                <span>Permisos</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link menu-link" href="/config/rols">
                                                </i><span>Roles</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link menu-link" href="/config/users">
                                                <span>Usuarios</span>
                                            </a>
                                        </li>                                        
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
                @endcan
            </ul>


            @if(auth()->user()->perfil=="E")
            <ul class="navbar-nav" id="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link menu-link" href="/academic/calendario">
                        <i class="las la-tachometer-alt fs-20"></i> <span>Agenda Escolar</span>
                    </a>
                </li>
                <li class="menu-title"><i class="ri-more-fill"></i> <span>MODULOS</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#actividades" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="actividades">
                        <i class="las la-calendar-check fs-20"></i><span>Actividades</span>
                    </a>
                    <div class="collapse menu-dropdown" id="actividades">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="/academic/tuition">
                                    </i>Ver Actividades<span></span>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="/academic/tuition">
                                    </i>Visualización Rapida<span></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#mensajeria" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="mensajeria">
                        <i class="las la-sms fs-20"></i><span>Mensajeria</span>
                    </a>
                    <div class="collapse menu-dropdown" id="mensajeria">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="/academic/tuition">
                                    </i>Bandeja de Entrada<span></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#clase" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="clase">
                        <i class="las la-video fs-20"></i><span>Clases Virtuales</span>
                    </a>
                    <div class="collapse menu-dropdown" id="clase">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="/academic/tuition">
                                    </i>Registrar Clase Virtual<span></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="collapse menu-dropdown" id="clase">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="/academic/tuition">
                                    </i>Unirse a Clase Virtual<span></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#recursos" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="recursos">
                        <i class="las la-file-alt fs-20"></i><span>Recursos</span>
                    </a>
                    <div class="collapse menu-dropdown" id="recursos">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="/academic/tuition">
                                    </i>Recursos por Materia<span></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#eventos" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="eventos">
                        <i class="las la-calendar fs-20"></i><span>Eventos</span>
                    </a>
                    <div class="collapse menu-dropdown" id="eventos">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="/academic/tuition">
                                    </i>Ver Eventos<span></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#notificaciones" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="notificaciones">
                        <i class="las la-bell fs-20"></i><span>Notificaciones</span>
                    </a>
                    <div class="collapse menu-dropdown" id="notificaciones">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="/academic/tuition">
                                    </i>Ver Notificaciones<span></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#calificacion" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="calificacion">
                        <i class="las la-award fs-20"></i><span>Calificaciones</span>
                    </a>
                    <div class="collapse menu-dropdown" id="calificacion">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="/academic/tuition">
                                    </i>Detalle por Materia<span></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="/academic/tuition">
                                    </i>Resumen Parcial<span></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="/academic/tuition">
                                    </i>Resumen Trimestral<span></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="/academic/tuition">
                                    </i>Reporte de Conducta<span></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#faltas" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="faltas">
                        <i class="las la-tasks fs-20"></i><span>Justificativo de Faltas</span>
                    </a>
                    <div class="collapse menu-dropdown" id="faltas">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#">
                                    </i>Justificar<span></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
            @endif
        </div>
        <!-- Sidebar -->
    </div>
    <!--<div class="sidebar-background"></div>-->
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<!--<div class="vertical-overlay"></div>
