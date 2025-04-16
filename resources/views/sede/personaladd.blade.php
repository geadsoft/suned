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
            Sede
        @endslot
        @slot('title')
            Personal Sede Educativa
        @endslot
    @endcomponent

    @livewire('vc-personaladd',['personaId' => $id])

@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/list.js/list.js.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/list.pagination.js/list.pagination.js.min.js') }}"></script>

    <!--ecommerce-customer init js -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>

    <script>
       
        window.addEventListener('msg-validanui', event => {
            swal("Error!", "Número de identificación ya Existe...", "warning");
            document.getElementById("txtnui").value = "";             
        })

        window.addEventListener('msg-save', event => {
            swal("Buen trabajo!", "¡Registro guardado exitosamente!", "success");
        })

        window.addEventListener('msg-updated', event => {
            swal("Buen trabajo!", "¡Registro actualizado exitosamente!", "success");
        })

    </script>
    
@endsection
