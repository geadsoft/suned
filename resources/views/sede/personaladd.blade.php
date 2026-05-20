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
            Sede
        @endslot
        @slot('title')
            Personal Sede Educativa
        @endslot
    @endcomponent

    @livewire('vc-personaladd',[
        'personaId' => $id,
        'action' => $action
    ])

@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/list.js/list.js.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/list.pagination.js/list.pagination.js.min.js') }}"></script>

    <!--ecommerce-customer init js -->
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>

    <script>
       
        window.addEventListener('msg-validanui', event => {
            swal("Error!", "Número de identificación ya Existe...", "warning");
            document.getElementById("txtnui").value = "";             
        })

        window.addEventListener('view-alert', event => {

            Swal.fire({
                title: 'Datos registrado',
                text: 'La identificación ya está registrada como estudiante. ¿Desea cargar y actualizar los datos?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, cargar datos',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('editData');
                }
            });            
        })

        window.addEventListener('msg-save', event => {
            swal("Buen trabajo!", "¡Registro guardado exitosamente!", "success");
        })

        window.addEventListener('msg-updated', event => {
            swal("Buen trabajo!", "¡Registro actualizado exitosamente!", "success");
        })

        window.addEventListener('msg-error', event => {
            swal("Error!", event.detail.newName, "warning");
        })

    </script>
    
@endsection
