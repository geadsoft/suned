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
            Actividades
        @endslot
        @slot('title')
            Crear Actividades
        @endslot
    @endcomponent

    @livewire('vc-actividad-add',['id' => $id])

@endsection
@section('script')
    <!--ecommerce-customer init js -->

    
    <script src="{{ URL::asset('assets/libs/@ckeditor/@ckeditor.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/ecommerce-product-create.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    

    <script>
       
        window.addEventListener('msg-grabar', event => {
            swal("Buen Trabajo!", event.detail.newName, "success");
        })

        window.addEventListener('chk-editor', event => {

            ClassicEditor.create(document.querySelector('#ckeditor-classic')).then(function (editor) {
            editor.ui.view.editable.element.style.height = '200px';
            })["catch"](function (error) {
            console.error(error);
            });

         })

    </script>
    
@endsection
