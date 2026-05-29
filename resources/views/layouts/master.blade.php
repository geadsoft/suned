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
<!-- Modal Sesión -->
<div class="modal fade"
     id="sessionWarningModal"
     tabindex="-1"
     data-bs-backdrop="static"
     data-bs-keyboard="false">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header" style="background-color: #222454;">
                <h5 class="modal-title text-white">
                    Sesión por expirar
                </h5>
            </div>

            <div class="modal-body text-center">

                <div class="mb-3">
                    <i class="ri-time-line text-warning"
                       style="font-size:60px;"></i>
                </div>

                <p class="mb-1">
                    Tu sesión se cerrará por inactividad en:
                </p>

                <h1 id="countdown"
                    class="text-danger fw-bold">
                    60
                </h1>

            </div>

            <div class="modal-footer justify-content-center">

                <button type="button"
                        class="btn btn-success"
                        id="continueSessionBtn">

                    Continuar Sesión

                </button>

            </div>

        </div>

    </div>

</div>
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

    <script>

        // =========================
        // CONFIGURACIÓN
        // =========================

        // Tiempo total de inactividad
        const logoutAfterMs = 30 * 60 * 1000; // 30 minutos

        // Mostrar alerta 1 minuto antes
        const warningBeforeMs = 1 * 60 * 1000;

        let logoutTimer;
        let warningTimer;
        let countdownInterval;

        const sessionModal = new bootstrap.Modal(
            document.getElementById('sessionWarningModal')
        );

        // =========================
        // REINICIAR TEMPORIZADORES
        // =========================

        function resetLogoutTimer() {

            clearTimeout(logoutTimer);
            clearTimeout(warningTimer);
            clearInterval(countdownInterval);

            sessionModal.hide();

            // Mostrar advertencia
            warningTimer = setTimeout(() => {

                showSessionWarning();

            }, logoutAfterMs - warningBeforeMs);

            // Cerrar sesión
            logoutTimer = setTimeout(() => {

                window.location.href = "{{ route('auto.logout') }}";

            }, logoutAfterMs);

        }

        // =========================
        // MOSTRAR MODAL
        // =========================

        function showSessionWarning() {

            let seconds = warningBeforeMs / 1000;

            document.getElementById('countdown').innerText = seconds;

            sessionModal.show();

            countdownInterval = setInterval(() => {

                seconds--;

                document.getElementById('countdown').innerText = seconds;

                if(seconds <= 0){

                    clearInterval(countdownInterval);

                }

            }, 1000);

        }

        // =========================
        // CONTINUAR SESIÓN
        // =========================

        document.getElementById('continueSessionBtn')
        .addEventListener('click', function () {

            fetch("{{ url('/keep-alive') }}");

            resetLogoutTimer();

        });

        // =========================
        // EVENTOS ACTIVIDAD USUARIO
        // =========================

        ['click', 'mousemove', 'keydown', 'scroll', 'touchstart']
        .forEach(evt => {

            window.addEventListener(evt, resetLogoutTimer);

        });

        // =========================
        // INICIAR
        // =========================

        resetLogoutTimer();

    </script>
    
</body>

</html>
