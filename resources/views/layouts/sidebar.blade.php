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
                <img src="{{ URL::asset('assets/images/sams.png') }}" alt="" height="40">
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
                <li class="menu-title"><span>@lang('translation.home')</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarDashboards" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class="las la-tachometer-alt"></i> <span>@lang('translation.dashboards')</span>
                    </a>
                    <!--<div class="collapse menu-dropdown" id="sidebarDashboards">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="dashboard-analytics" class="nav-link">@lang('translation.analytics')</a>
                            </li>
                            <li class="nav-item">
                                <a href="dashboard-crm" class="nav-link">@lang('translation.crm')</a>
                            </li>
                            <li class="nav-item">
                                <a href="index" class="nav-link">@lang('translation.ecommerce')</a>
                            </li>
                            <li class="nav-item">
                                <a href="dashboard-crypto" class="nav-link">@lang('translation.crypto')</a>
                            </li>
                            <li class="nav-item">
                                <a href="dashboard-projects" class="nav-link">@lang('translation.projects')</a>
                            </li>
                            <li class="nav-item">
                                <a href="dashboard-nft" class="nav-link" data-key="t-nft"> @lang('translation.nft') <span class="badge badge-pill bg-danger" data-key="t-new">@lang('translation.new')</span></a>
                            </li>
                        </ul>
                    </div>
                </li>--> <!-- end Dashboard Menu -->
                <li class="menu-title"><i class="ri-more-fill"></i> <span>@lang('translation.academic')</span></li>
                
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarPerson" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarPerson">
                        <i class="las la-user-check"></i> <span>@lang('translation.person')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarPerson">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="/academic/students" class="nav-link" role="button">@lang('translation.students')
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/academic/representatives" class="nav-link" role="button">@lang('translation.representatives')
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="" class="nav-link" role="button">@lang('translation.teachers')
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="/academic/tuition">
                        <i class="las la-address-card"></i> <span>@lang('translation.tuition')</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="">
                        <i class="las la-school"></i> <span>@lang('translation.subjects')</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="">
                        <i class="las la-clock"></i> <span>@lang('translation.schedules')</span>
                    </a>
                </li>

                <!--Sedes-->
                <li class="menu-title"><i class="ri-more-fill"></i> <span>@lang('translation.headquarters')</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="/headquarters/headquarters-add">
                        <i class="las la-address-card"></i> <span>@lang('translation.headquarter')</span>
                    </a>    
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="/headquarters/educational-services">
                        <i class="las la-chalkboard"></i> <span>@lang('translation.services')</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="/headquarters/pension">
                        <i class="las la-chalkboard"></i> <span>@lang('translation.charges')</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="/academic/course">
                        <i class="las la-chalkboard"></i> <span>@lang('translation.course')</span>
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
                        <i class="las la-donate"></i> <span>Registrar Cobro</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="/financial/account-status">
                        <i class="las la-archive"></i> <span>@lang('translation.statement-of-account')</span>
                    </a>
                </li>
                <!--<li class="nav-item">
                    <a class="nav-link menu-link" href="/financial/create-invoice">
                        <i class="las la-archive"></i> <span>@lang('translation.create_invoice')</span>
                    </a>
                </li>-->
                              
                <li class="menu-title"><i class="ri-more-fill"></i> <span>@lang('translation.reports')</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarreport" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarreport">
                        <i class="ri-menu-add-line"></i> <span>Reportes</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarreport">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="/report/box-balance">
                                    <i class="las la-cash-register"></i> <span>@lang('translation.cash-receipt')</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="/report/daily-charges">
                                    <i class="las la-file-invoice-dollar"></i> <span>@lang('translation.daily-cobros')</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="">
                                    <i class="las la-chart-pie"></i> <span>@lang('translation.debt-analysis')</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="">
                                    <i class="las la-sliders-h"></i> <span>@lang('translation.generic')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarGrafico" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarGrafico">
                        <i class="ri-menu-add-line"></i> <span>Gráficos</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarGrafico">
                        <ul class="nav nav-sm flex-column">
                        </ul>
                    </div>
                </li>
                <li class="menu-title"><i class="ri-more-fill"></i> <span>@lang('translation.config')</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="/config/generality">
                        <i class="las la-flask"></i> <span>@lang('translation.generality')</span>
                    </a>
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
