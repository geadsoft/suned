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
                <li class="menu-title"><i class="ri-more-fill"></i> <span>@lang('translation.academic')</span></li>
                
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
                <!--<li class="nav-item">
                    <a class="nav-link menu-link" href="">
                        <i class="las la-clock fs-20"></i> <span>@lang('translation.schedules')</span>
                    </a>
                </li>-->

                <!--Sedes-->
                <li class="menu-title"><i class="ri-more-fill"></i> <span>@lang('translation.headquarters')</span></li>

                <a class="nav-link menu-link" href="#sidebarsede" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarsede">
                    <i class="ri-menu-add-line fs-20"></i> <span>Sede</span>
                </a>
                <div class="collapse menu-dropdown" id="sidebarsede">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="/headquarters/headquarters-add">
                                <i class="mdi mdi-*-* mdi-bank-check fs-20"></i> <span>@lang('translation.headquarter')</span>
                            </a>    
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="/headquarters/educational-services">
                                <i class="mdi mdi-*-* mdi-cart fs-20"></i> <span>@lang('translation.services')</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="/headquarters/pension">
                                <i class="mdi mdi-*-* mdi-layers fs-20"></i> <span>@lang('translation.charges')</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <a class="nav-link menu-link" href="#personalce" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarsede">
                    <i class="mdi mdi-*-* mdi-account-group fs-20"></i> <span>Personal CE</span>
                </a>
                <div class="collapse menu-dropdown" id="personalce">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="/headquarters/staff">
                                <i class="las la-address-card fs-20"></i> <span>Fichas</span>
                            </a>    
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="">
                                <i class="las la-address-card fs-20"></i> <span>Ficha</span>
                            </a>    
                        </li>
                    </ul>
                </div>
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

                <!--<li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarLayouts" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarLayouts">
                        <i class="las la-columns"></i> <span>@lang('translation.staff')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarLayouts">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="layouts-horizontal" target="_blank" class="nav-link">@lang('translation.horizontal')</a>
                            </li>
                            <li class="nav-item">
                                <a href="layouts-detached" target="_blank" class="nav-link">@lang('translation.detached')</a>
                            </li>
                            <li class="nav-item">
                                <a href="layouts-two-column" target="_blank" class="nav-link">@lang('translation.two-column')</a>
                            </li>
                            <li class="nav-item">
                                <a href="layouts-vertical-hovered" target="_blank" class="nav-link">@lang('translation.hovered')</a>
                            </li>
                        </ul>
                    </div>
                </li>--> <!-- end Dashboard Menu -->

                <li class="menu-title"><i class="ri-more-fill"></i> <span>@lang('translation.financial')</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="/financial/encashment">
                        <i class="las la-donate fs-20"></i> <span>Registrar Cobro</span>
                    </a>
                </li>
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
                <li class="nav-item">
                    <a class="nav-link menu-link" href="/financial/account-status">
                        <i class="las la-archive fs-20"></i> <span>@lang('translation.statement-of-account')</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="/financial/list-income">
                        <i class="las la-archive fs-20"></i> <span>@lang('translation.list-income')</span>
                    </a>
                </li>
                <!--<li class="nav-item">
                    <a class="nav-link menu-link" href="/financial/create-invoice">
                        <i class="las la-archive"></i> <span>@lang('translation.create_invoice')</span>
                    </a>
                </li>-->
                <li class="menu-title"><i class="ri-more-fill"></i> <span>Inventario</span></li>
                <a class="nav-link menu-link" href="#productos" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarsede">
                    <i class="ri-shopping-cart-2-line fs-20"></i> <span>Productos & Servicios</span>
                </a>
                <div class="collapse menu-dropdown" id="productos">
                    <ul class="nav nav-sm flex-column">
                        <a class="nav-link menu-link" href="/inventary/products">
                            <i class="ri-price-tag-3-line fs-20"></i> <span>Catálogo</span>
                        </a>
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
                        

                        <a class="nav-link menu-link" href="/inventary/stock">
                            <i class="ri-swap-line fs-20"></i> <span>Stock</span>
                        </a>
                    </ul>
                </div>
                <li class="menu-title"><i class="ri-more-fill"></i> <span>Secretaria</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="/secretary/certificate">
                        <i class="ri-article-line fs-20"></i> <span>Certificados</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#calificaciones" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarsede">
                        <i class="ri-medal-2-fill fs-20"></i> <span>Calificaciones</span>
                    </a>
                    <div class="collapse menu-dropdown" id="calificaciones">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="/secretary/promotion">
                                    <i class="ri-file-ppt-line fs-20"></i> <span>Certf. de Promoción</span>
                                </a>    
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="/secretary/ratings">
                                    <i class="bx bxs-graduation fs-20"></i> <span>Calificaciones</span>
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
                                    <i class="ri-file-add-line fs-20"></i> <span>Registro</span>
                                </a>    
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="/secretary/report-cas">
                                    <i class="ri-contacts-book-upload-line fs-20"></i> <span>Ingreso de CAS</span>
                                </a>    
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="/secretary/titles-file">
                                    <i class="ri-character-recognition-line fs-20"></i> <span>Títulos y Actas</span>
                                </a>    
                            </li>
                        </ul>
                    </div>
                    <!--<a class="nav-link menu-link" href="/secretary/documentation">
                        <i class="ri-book-3-line fs-20"></i> <span>Documentacion</span>
                    </a>-->
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="/secretary/requests">
                        <i class="ri-bubble-chart-fill fs-20"></i> <span>Solicitudes</span>
                    </a>
                </li>

                <li class="menu-title"><i class="ri-more-fill"></i> <span>@lang('translation.reports')</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#reportfinanciero" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="reportfinanciero">
                        <i class="ri-menu-add-line fs-20"></i> <span>Reportes Academicos</span>
                    </a>
                    <div class="collapse menu-dropdown" id="reportfinanciero">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="">
                                    <i class="ri-folder-open-line fs-20"></i> <span>Documentación</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="">
                                    <i class="ri-medal-2-line fs-20"></i> <span>Calificaciones</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <a class="nav-link menu-link" href="#sidebarreport" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarreport">
                        <i class="ri-menu-add-line fs-20"></i> <span>Reportes Financieros</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarreport">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="/report/box-balance">
                                    <i class="las la-cash-register fs-20"></i> <span>@lang('translation.cash-receipt')</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="/report/daily-charges">
                                    <i class="las la-file-invoice-dollar fs-20"></i> <span>@lang('translation.daily-cobros')</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="/report/debt-analysis">
                                    <i class="las la-chart-pie fs-20"></i> <span>@lang('translation.debt-analysis')</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="/report/generic-reports">
                                    <i class="las la-sliders-h fs-20"></i> <span>@lang('translation.generic')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <a class="nav-link menu-link" href="#sidebarproduct" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarreport">
                        <i class="ri-menu-add-line fs-20"></i> <span>Reportes Productos</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarproduct">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="/inventary/detail-products">
                                    <i class="las la-sliders-h fs-20"></i> <span>Detalle de Productos</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="menu-title"><i class="ri-more-fill"></i> <span>@lang('translation.config')</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="/config/generality">
                        <i class="ri-tools-fill fs-20"></i> <span>@lang('translation.generality')</span>
                    </a>
                </li>
                <a class="nav-link menu-link" href="#sidebaruser" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarreport">
                    <i class="ri-menu-add-line fs-20"></i> <span>Usuarios</span>
                </a>
                <div class="collapse menu-dropdown" id="sidebaruser">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="/config/users">
                                <i class="las la-user-tie fs-20"></i> <span>Usuarios</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="/config/rols">
                                <i class="las la-suitcase-rolling fs-20"></i> <span>Roles</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="/config/permissions">
                                <i class="las la-check-circle fs-20"></i> <span>Permisos</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
    <!--<div class="sidebar-background"></div>-->
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<!--<div class="vertical-overlay"></div>
