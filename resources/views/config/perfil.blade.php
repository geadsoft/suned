@extends('layouts.master')
@section('title')
    @lang('translation.settings')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
@endsection
@section('content')
 
    @livewire('vc-config-profile')

@endsection

@section('script')

    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    
    <script>
    
        window.addEventListener('msg-save', event => {
            swal("Buen trabajo!", "¡Registro guardado exitosamente!", "success");
        })

        window.addEventListener('msg-update', event => {
            swal("Buen trabajo!", "¡Registro actualizado exitosamente!", "success");
        })

         window.addEventListener('msg-alert', event => {
            swal("No se puede Eliminar!",event.detail.newName, "error");
        })

        window.addEventListener('msg-password', event => {
            swal("Mensaje", "¡Contraseña actualizada con éxito!", "success");
        })

    </script>
    
@endsection
