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
            Sede Educativa
        @endslot
        @slot('title')
            Sistema Educativo
        @endslot
    @endcomponent

    @livewire('vc-sistema-educativo')

@endsection
@section('script')
    
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>

    <script>
       
        window.addEventListener('msg-grabar', event => {
            swal("Buen Trabajo!", event.detail.newName, "success");
        });

        window.addEventListener('msg-delete-hora', event => {
            swal({
                title: "No se puede eliminar",
                text: "La hora no puede eliminarse porque está asignada en un horario de clase.",
                icon: "warning",
                button: "Aceptar",
            });
        });

        window.addEventListener('abrir-modal-replica', event => {
            var modal = new bootstrap.Modal(document.getElementById('replicaModal'));
            modal.show();
        });
        
        window.addEventListener('hide-replica-modal', event => {
            var modalEl = document.getElementById('replicaModal');
            var modal = bootstrap.Modal.getInstance(modalEl);
            if(modal) modal.hide();
        });

        window.addEventListener('show-form', event => {
            $('#horaModal').modal('show');
        })

        window.addEventListener('hide-form', event => {
            $('#horaModal').modal('hide');
        })

        window.addEventListener('alert-delete', event => {
            swal({
                title: "¿Eliminar registro?",
                text: "Esta acción no se puede deshacer.",
                icon: "warning",
                buttons: {
                    cancel: "Cancelar",
                    confirm: {
                        text: "Sí, eliminar",
                        value: true,
                    }
                },
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    Livewire.emit('deleteHora');
                }
            });
        });

        window.addEventListener('cerrarModalApertura', function () {
            let modal = bootstrap.Modal.getInstance(document.getElementById('modalAperturarPeriodo'));
            modal.hide();
        });

        window.addEventListener('alert', function(event){

            Swal.fire({
                icon: event.detail.type,
                title: event.detail.title,
                text: event.detail.message,
                confirmButtonColor: '#222454'
            }).then((result) => {

                if (result.isConfirmed && event.detail.type === 'success') {
                    location.reload();
                }

            });

        });
        

    </script>
    
@endsection
