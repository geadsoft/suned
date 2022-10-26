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
            Financial
        @endslot
        @slot('title')
        Register of Encashments
        @endslot
    @endcomponent

    @livewire('vc-encashmentadd')

@endsection

@section('script')
    <!--
    <script src="{{ URL::asset('assets/libs/list.js/list.js.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/list.pagination.js/list.pagination.js.min.js') }}"></script>-->
    

    <!--ecommerce-customer init js -->
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/financial-encashment.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>

    <script>
        
        window.addEventListener('save-det', event => {
            
            /*var pagos  = document.getElementsByClassName("pagos");*/
            var deudas = document.getElementsByClassName("deudas");

            var count = 1;
            var new_pago_obj = [];
            var new_deuda_obj = [];
            

            /*pagos.forEach(element => {
                var col_tipopago = element.querySelector("#cmbtipopago-"+count).value;
                var col_entidad = element.querySelector("#cmbentidad-"+count).value;
                var col_valor = element.querySelector("#txtvalor-"+count).value;
                var col_referencia = element.querySelector("#txtreferencia-"+count).value;
                                
                var pago_obj = {
                    tipopago: col_tipopago,
                    entidadid: col_entidad,
                    numero: 0,
                    valor: col_valor,
                    referencia: col_referencia,
                }
                new_pago_obj.push(pago_obj);
                count++;
            });*/


                deudas.forEach(element => {
                    var col_desc = element.querySelector("#desc-"+count).value;
                    var col_saldo = element.querySelector("#saldo-"+count).value;
                
                                    
                    var deuda_obj = {
                        descuento: col_desc,
                        saldo: col_desc,
                    }
                    new_deuda_obj.push(deuda_obj);
                    count++;
                });

            

            Livewire.emit('postAdded',new_deuda_obj);
        
        })

    </script>    
    
    
    
@endsection
