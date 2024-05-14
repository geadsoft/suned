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
        <!--<button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-default" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>-->
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span>@lang('translation.home')</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="/">
                        <i class="las la-tachometer-alt fs-20"></i> <span>@lang('translation.dashboards')</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="/report/statistical-graphs">
                        <i class="las la-chart-pie fs-20"></i> <span>Gráficos</span>
                    </a>
                </li>
                <li class="menu-title"><i class="ri-more-fill"></i> <span>MODULOS</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#academico" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="academico">
                        <i class=" las la-graduation-cap fs-20"></i><span>Academico</span>
                    </a>
                    <div class="collapse menu-dropdown" id="academico">
                        <ul class="nav nav-sm flex-column">
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
                                            <a href="/academic/students" class="nav-link" role="button">Control de Asistencia</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="/academic/ratings" class="nav-link" role="button">Calificaciones</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="/academic/ratings-period" class="nav-link" role="button">Calificacion Periodo</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="/academic/representatives" class="nav-link" role="button">@lang('translation.representatives')
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="/academic/tuition">
                                    <i class="las la-address-card fs-20"></i> <span>@lang('translation.tuition')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!--Sedes-->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sede" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sede">
                        <i class="las la-school fs-20"></i> <span>Sede Educativa</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sede">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#sidebarsede" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarsede">
                                    <i class="mdi mdi-*-* mdi-bank-check fs-20"></i> <span>Sede</span>
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
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#administracion" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarsede">
                                    <i class="las la-cog fs-20"></i> <span>Administración</span>
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
                                                <i class="las la-stopwatch fs-20"></i> <span>Horarios Escolares</span>
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
                        </ul>
                    <div>
                </li>
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
                <!--Consultas-->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#consultas" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sede">
                        <i class="las la-print fs-20"></i> <span>Reportes</span>
                    </a>
                    <div class="collapse menu-dropdown" id="consultas">
                        <ul class="nav nav-sm flex-column">
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
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#sidebarproduct" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarreport">
                                    <i class="las la-clipboard-list fs-20"></i> <span>Inventario</span>
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarproduct">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link menu-link" href="/inventary/detail-products">
                                                <span>Detalle de Productos</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
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
                                    <i class="las la-user-check fs-20"></i> <span>Usuarios</span>
                                </a>
                                <div class="collapse menu-dropdown" id="sidebaruser">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link menu-link" href="/config/users">
                                                <span>Registrar</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link menu-link" href="/config/rols">
                                                </i> <span>Roles</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link menu-link" href="/config/permissions">
                                                <span>Permisos</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
    <!--<div class="sidebar-background"></div>-->
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<!--<div class="vertical-overlay"></div>
