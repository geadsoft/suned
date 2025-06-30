<!doctype html >
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">
 
<head>
    <meta charset="utf-8" />
    <title>Sams | School and Administrative Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="School and Administrative Management System" name="description" />
    <meta content="Christian Galarza" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('assets/images/samsueas.ico')}}">
    
    @include('layouts.head-css')
    @livewireStyles
    
</head>
<script>
    const logoutAfterMs = 30 * 60 * 1000; // 15 minutos
    let logoutTimer;

    function resetLogoutTimer() {
        clearTimeout(logoutTimer);
        logoutTimer = setTimeout(() => {
            document.getElementById('logout-form').submit();
        }, logoutAfterMs);
    }

    // Escucha eventos de actividad del usuario
    ['click', 'mousemove', 'keydown', 'scroll', 'touchstart'].forEach(evt => {
        window.addEventListener(evt, resetLogoutTimer);
    });

    // Inicializa el temporizador
    resetLogoutTimer();
</script>
@section('body')
    @include('layouts.body')
@show
    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('layouts.topbar')

        @include('layouts.sidebar')

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            @include('layouts.footer')
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    <!-- JAVASCRIPT -->
    @include('layouts.vendor-scripts')
    @livewireScripts
    
</body>

</html>
