@extends('layouts.master')
@section('title') @lang('translation.file-manager') @endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Docente
        @endslot
        @slot('title')
            Biblioteca
        @endslot
    @endcomponent

    @livewire('vc-library')

@endsection
@section('script')

    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>       

        window.addEventListener('show-form', event => {
            $('#addBookModal').modal('show');
        })

        window.addEventListener('hide-form', event => {
            $('#addBookModal').modal('hide');
        })
        
    </script>

@endsection
