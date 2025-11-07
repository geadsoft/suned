@extends('layouts.master')
@section('title')
    @lang('translation.task-details')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            PPE
        @endslot
        @slot('title')
            Fase del Programa
        @endslot
    @endcomponent

    @livewire('vc-ppe-fases',['fase' => $fase])

@endsection
@section('script')

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>

    <script>
       
        window.addEventListener('show-form', event => {
            $('#showModal').modal('show');
        })

        window.addEventListener('hide-form', event => {
            $('#showModal').modal('hide');
        })

        window.addEventListener('show-delete', event => {
            $('#deleteOrder').modal('show');
        })

        window.addEventListener('hide-delete', event => {
            $('#deleteOrder').modal('hide');
        })

        window.addEventListener('show-class', event => {
            $('#showClass').modal('show');
        })

        window.addEventListener('hide-class', event => {
            $('#showClass').modal('hide');
        })

        window.addEventListener('msg-vacio', event => {
            swal("No hay fecha asignada!", "Por favor, prográmala para continuar.", "error");
        })

    </script>
    
@endsection
