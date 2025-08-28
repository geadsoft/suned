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
            Recursos
        @endslot
        @slot('title')
            Libro Digital
        @endslot
    @endcomponent

    @livewire('vc-flipbook-viewer',['fileId' => $id])

@endsection
@section('script')

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
 
@endsection