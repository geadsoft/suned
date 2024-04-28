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
            Inventario
        @endslot
        @slot('title')
            Movimientos
        @endslot
    @endcomponent

    @livewire('vc-inventary-register')

@endsection
@section('script')
    <!--ecommerce-customer init js -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>

    <script>
       
        window.addEventListener('show-form', event => {
            $('#showProducto').modal('show');
        })

        document.addEventListener('livewire:load', () => { 
            window.livewire.on('newfocus', inputname => { 
                document.getElementById("searchproducto").focus();
            }) 
        })

        window.addEventListener('hide-form', event => {
            $('#showProducto').modal('hide');
        })

        window.addEventListener('show-persona', event => {
            $('#showModalBuscar').modal('show');
        })

        window.addEventListener('hide-persona', event => {
            $('#showModalBuscar').modal('hide');
        })

        window.addEventListener('msg-grabar', event => {
            swal("Buen Trabajo!", event.detail.newName, "success");
        })

        window.addEventListener('error-stock', event => {
            swal("Error!", event.detail.newName, "warning");
        })

    </script>
    
@endsection
