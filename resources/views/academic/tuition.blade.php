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
            Academic
        @endslot
        @slot('title')
            Tuition
        @endslot
    @endcomponent

    @livewire('vc-tuitions')

@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/list.js/list.js.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/list.pagination.js/list.pagination.js.min.js') }}"></script>

    <!--ecommerce-customer init js -->
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>    

    <script>
       
        window.addEventListener('show-form', event => {
            $('#showModalSection').modal('show');
        })

        window.addEventListener('hide-form', event => {
            $('#showModalSection').modal('hide');
        })

        window.addEventListener('msg-edit', event => {
            swal("Good job!", "Record updated successfully!", "success");
        })

        window.addEventListener('get-data', event => {
            
            var grupoId = document.getElementById("cmbgrupoId").value;
            var nivelId = document.getElementById("cmbnivelId").value;
            var gradoId = document.getElementById("cmbgradoId").value;
            var cursoId = document.getElementById("cmbcursoId").value;

            var registro = {
                grupoid: grupoId,
                nivelid: nivelId,
                gradoid: gradoId,
                cursoid: cursoId,
            }
            Livewire.emit('setData',registro);

        })

    </script>

@endsection
