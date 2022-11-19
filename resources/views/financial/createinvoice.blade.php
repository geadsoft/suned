@extends('layouts.master')
@section('title')
    @lang('translation.create-invoice')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet">
    <!-- Sweet Alert css-->
    <link href="{{ URL::asset('assets/libs/dropzone/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Financial
        @endslot
        @slot('title')
            Create Invoice
        @endslot
    @endcomponent

    @livewire('vc-createinvoice')

@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/dropzone/dropzone.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/cleave.js/cleave.js.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/invoicecreate.init.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>

@endsection