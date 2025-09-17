@extends('layouts.master')
@section('title')
    @lang('translation.create-invoice')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet">
    <!-- Sweet Alert css-->
    <link rel="stylesheet" href="https://unpkg.com/st-pageflip/dist/css/st-pageflip.min.css">
    <script src="https://unpkg.com/st-pageflip/dist/js/st-pageflip.browser.min.js"></script>
    
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