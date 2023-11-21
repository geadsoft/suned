
@extends('layouts.master')
@section('title')
    @lang('translation.orders')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Académico
        @endslot
        @slot('title')
            Calificaciones
        @endslot
    @endcomponent

    @livewire('vc-calificacionesadd')

@endsection
@section('script')

    <!--ecommerce-customer init js -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>

    <script>

        window.addEventListener('msg-grabar', event => {
            swal("Buen trabajo!", "¡Registros guardados exitosamente!", "success");
        })

        window.addEventListener('msg-editar', event => {
            swal("Buen trabajo!", "Registros actualizados exitosamente!", "success");
        })
        
    </script>   
     
@endsection
