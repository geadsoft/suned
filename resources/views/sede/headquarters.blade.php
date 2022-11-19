@extends('layouts.master')
@section('title')
    @lang('translation.products')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/nouislider/nouislider.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::asset('assets/libs/gridjs/gridjs.min.css') }}">
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Educational Headquarters
        @endslot
        @slot('title')
            Headquarters
        @endslot
    @endcomponent

    @livewire('vc-headquarters')

@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/list.js/list.js.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/profile-setting.init.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/nouislider/nouislider.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/wnumb/wnumb.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/gridjs/gridjs.min.js') }}"></script>
    <script src="https://unpkg.com/gridjs/plugins/selection/dist/selection.umd.js"></script>


    <script src="{{ URL::asset('assets/js/pages/ecommerce-product-list.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>

    <script>
        
        window.addEventListener('selected-zonas', event => {
            
            var a = document.getElementById("cmbprovince");
            var idprovincia = a.options[a.selectedIndex].value;

            var b = document.getElementById("cmbcity");
            var idcanton = b.options[b.selectedIndex].value;

            var c = document.getElementById("cmbparish");
            var idparroquia = c.options[c.selectedIndex].value;

            Livewire.emit('postAdded',idprovincia,idcanton,idparroquia);
        })

    </script>


@endsection