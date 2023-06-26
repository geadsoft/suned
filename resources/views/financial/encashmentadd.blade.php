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

    @livewire('vc-encashmentadd',['periodoid' => $periodoid,'matriculaid' => $matriculaid])

@endsection

@section('script')
    <!--ecommerce-customer init js -->
    <script src="{{ URL::asset('assets/js/pages/financial-encashment.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>

    <script>
        
        window.addEventListener('show-message', event => {
            $('#messageModal').modal('show');
        })

        $("#cmbtipopago").change(function(){
            var tipo = document.getElementById('cmbtipopago').value

            document.querySelector('label[name="lblentidad"]').style.display = "none";
            document.querySelector('select[name="cmbentidad"]').style.display = "none";
            document.querySelector('select[name="cmbtarjeta"]').style.display = "none";

            switch(tipo) {
            case 'CHQ':
                document.querySelector('select[name="cmbentidad"]').style.display = "inline-block";
                document.querySelector('label[name="lblentidad"]').style.display = "inline-block";
                break;
            case 'DEP':
                document.querySelector('select[name="cmbentidad"]').style.display = "inline-block";
                document.querySelector('label[name="lblentidad"]').style.display = "inline-block";
                break;
            case 'TRA':
                document.querySelector('select[name="cmbentidad"]').style.display = "inline-block";
                document.querySelector('label[name="lblentidad"]').style.display = "inline-block";
                break;
            case 'TAR':
                document.querySelector('label[name="lblentidad"]').style.display = "inline-block";
                document.querySelector('select[name="cmbtarjeta"]').style.display = "inline-block";
                break;
            }

        })
        
        window.addEventListener('save-det', event => {
                          
            /*Pagos*/
            var count = 0;
            var new_pago_obj = [];
            var deuda_list;

            const tableRows = document.querySelectorAll('#newlink tr');
            let col_tipopago = '';
            let col_entidad  = '';
            let col_valor = '';
            let col_referencia = '';
            
            for(let i=0; i<tableRows.length; i++) {
                const row = tableRows[i];
                count = row.id;
                col_tipopago   = row.querySelector("#cmbtipopago-"+count).value;
                col_entidad    = row.querySelector("#cmbentidad-"+count).value;
                col_valor      = row.querySelector("#txtvalor-"+count).value;
                col_referencia = row.querySelector("#txtreferencia-"+count).value;

                var pago_obj = {
                    tipopago: col_tipopago,
                    entidadid: col_entidad,
                    numero: 0,
                    valor: col_valor,
                    referencia: col_referencia,
                }
                new_pago_obj.push(pago_obj);
            }

            deuda_list = JSON.parse(localStorage.getItem('deuda-list'));
            
            Livewire.emit('postAdded',deuda_list,new_pago_obj);
        
        })

    </script>    
    
    
    
@endsection
