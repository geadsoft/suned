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
            Inventario
        @endslot
        @slot('title')
            Productos Vendidos
        @endslot
    @endcomponent

    @livewire('vc-report-producto-vendido')

@endsection
@section('script')
    <!--ecommerce-customer init js -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/reports-graphs.js') }}"></script>

    <script>
    
        window.addEventListener('graph-vtaund', event => {
            var datacategories
            var dataserie 
            datacategories = JSON.parse(event.detail.newObj1);
            dataserie = JSON.parse(event.detail.newObj2);

            alert(dataserie)            
            viewGraphsVta1(dataserie);
        })

        window.addEventListener('graph-vtamonto', event => {
            var dataserie 
            dataserie = JSON.parse(event.detail.newObj);
            viewGraphsVta2(dataserie);
        })

        window.addEventListener('graph-vtacant', event => {
            var dataserie 
            dataserie = JSON.parse(event.detail.newObj);
            viewGraphsVta3(dataserie);
        })

    </script>

@endsection
