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
            Financiero
        @endslot
        @slot('title')
        Registro de Cobros
        @endslot
    @endcomponent

    @livewire('vc-encashment',['id' => $id])

@endsection

@section('script')
    <!--
    <script src="{{ URL::asset('assets/libs/list.js/list.js.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/list.pagination.js/list.pagination.js.min.js') }}"></script>-->
    

    <!--ecommerce-customer init js -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{ URL::asset('assets/js/pages/financial-encashment.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    
    <script>

        window.addEventListener('show-form', event => {
            $('#showModalBuscar').modal('show');
        })

        window.addEventListener('hide-form', event => {
            $('#showModalBuscar').modal('hide');
        })

        window.addEventListener('show-delete', event => {
            $('#deleteCobro').modal('show');
        })

        window.addEventListener('hide-delete', event => {
            $('#deleteCobro').modal('hide');
        })

        window.addEventListener('show-anular', event => {
            $('#anulaCobro').modal('show');
        })

        window.addEventListener('hide-anular', event => {
            $('#anulaCobro').modal('hide');
        })


    </script>

    
    
@endsection
