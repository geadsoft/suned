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
            Config
        @endslot
        @slot('title')
            Company
        @endslot
    @endcomponent

    @livewire('vc-pension')

@endsection
@section('script')
    <script src="{{ URL::asset('/assets/libs/list.js/list.js.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/list.pagination.js/list.pagination.js.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    
    <script>
       
        window.addEventListener('show-form', event => {
            $('#showModal').modal('show');
        })

        window.addEventListener('hide-form', event => {
            $('#showModal').modal('hide');
        })

        window.addEventListener('show-delete', event => {
            $('#deleteData').modal('show');
        })

        window.addEventListener('hide-delete', event => {
            $('#deleteData').modal('hide');
        })
        
        window.addEventListener('save-det', event => {
            
            var products = document.getElementsByClassName("product");
            var count = 1;
            var new_pension_obj = [];

            products.forEach(element => {
                var col_nivel = element.querySelector("#nivel-"+count).value;
                var col_nombre = element.querySelector("#nombre-"+count).value;
                var col_matricula = element.querySelector("#matricula-"+count).value;
                var col_pension = element.querySelector("#pension-"+count).value;
                var col_plataforma = element.querySelector("#plataforma-"+count).value;
                                
                var pension_obj = {
                    id: col_nivel,
                    nombre: col_nombre,
                    matricula: col_matricula,
                    pension: col_pension,
                    plataforma: col_plataforma,
                }
                new_pension_obj.push(pension_obj);
                count++;
            });

            Livewire.emit('postAdded',new_pension_obj);
        
        })


    </script>

@endsection