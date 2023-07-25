@extends('layouts.master')
@section('title')
    @lang('translation.create-project')
@endsection
@section('css')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link href="{{ URL::asset('build/libs/dropzone/dropzone.css') }}" rel="stylesheet">
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Secretaría
        @endslot
        @slot('title')
            Certificados
        @endslot
    @endcomponent

    @livewire('vc-certificados')

@endsection
@section('script')
    <script src="{{ URL::asset('/assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>

    <script>

        window.addEventListener('show-form', event => {
            $('#showModalBuscar').modal('show');
        })

        window.addEventListener('hide-form', event => {
            $('#showModalBuscar').modal('hide');
        })

    </script>

@endsection