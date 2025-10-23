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
            Buzón
        @endslot
        @slot('title')
            Entradas
        @endslot
    @endcomponent

    @livewire('vc-mailbox-opinions')

@endsection

@section('script')
    
    <script src="{{ URL::asset('assets/libs/@ckeditor/@ckeditor.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/mailbox.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>
        window.addEventListener('msj-delete', event => {
            swal("Mensaje Eliminado!",'El registro ha sido eliminado correctamente.', "warning");
            location.reload();
        })

        window.addEventListener('msj-cerrar', event => {
            location.reload();
        })
    </script>
    
@endsection
