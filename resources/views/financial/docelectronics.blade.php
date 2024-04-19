@extends('layouts.master')
@section('title')
    @lang('translation.create-invoice')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet">
    <!-- Sweet Alert css-->
    <link href="{{ URL::asset('assets/libs/dropzone/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            SRI
        @endslot
        @slot('title')
            Facturas
        @endslot
    @endcomponent
    
    @livewire('vc-doc-electronics')

@endsection
@section('script')

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>

    <script>

        window.addEventListener('show-form', event => {
            $('#showCliente').modal('show');
        })

        window.addEventListener('hide-form', event => {
            $('#showCliente').modal('hide');
        })

        window.addEventListener('msg-ride', event => {
            var array;
            var mensaje;
           
            array = JSON.parse(event.detail.newObj);
            
            mensaje = "Factura No.: "+array.factura+"\nClave de Acceso: "+array.claveacceso+"\n"+array.mensaje

            if(array.error==0){
                swal("Buen Trabajo!",mensaje, "success");
            } else {
                swal("Error!",mensaje, "warning");
            }

        })
       
    </script> 

@endsection