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
            Exámenes
        @endslot
        @slot('title')
            Exámen Supletorio
        @endslot
    @endcomponent

    @livewire('vc-supletory-view',['id' => $id])

@endsection
@section('script')
    <!--ecommerce-customer init js -->

    
    <script src="{{ URL::asset('assets/libs/@ckeditor/@ckeditor.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/ecommerce-product-create.init.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>

    <script>
       
        window.addEventListener('msg-grabar', event => {
            swal("Buen Trabajo!", event.detail.newName, "success");
        })

        window.addEventListener('textArea', event => {
            addElement(event.detail.newName)
        })

        function addElement($text)
        {
            var $string = $text
             document.getElementById("elemnt").innerHTML += $string;
        }
        
        window.addEventListener('iniciar-descarga', event => {
            const url = event.detail.url;
            window.open(url, '_blank');
        });

    </script>
    
@endsection
