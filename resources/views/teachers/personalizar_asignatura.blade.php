@extends('layouts.master')
@section('title')
    @lang('translation.team')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Asignaturas
        @endslot
        @slot('title')
            Personalizar
        @endslot
    @endcomponent

    @livewire('vc-personalize-subjects')

@endsection
@section('script')
    <script src="{{ URL::asset('assets/js/pages/team.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    
    <script>

        window.addEventListener('msg-grabar', event => {
            swal("Buen Trabajo!", event.detail.newName, "success");
        })

    </script>
    
@endsection