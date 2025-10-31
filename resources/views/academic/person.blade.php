@extends('layouts.master')
@section('title')
    @lang('translation.orders')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.lordicon.com/lordicon-1.2.0.js"></script>
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Academic
        @endslot
        @slot('title')
            Students
        @endslot
    @endcomponent

    @livewire('vc-persons')

@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/list.js/list.js.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/list.pagination.js/list.pagination.js.min.js') }}"></script>

    <!--ecommerce-customer init js -->
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>

    <script>

       // Mostrar SweetAlert con input prellenado
        window.addEventListener('resetPasswordSwal', event => {
            Swal.fire({
                title: 'Restablecer Contraseña',
                input: 'password',
                inputLabel: 'Nueva contraseña',
                inputValue: event.detail.newName, // ← valor por defecto
                inputPlaceholder: '********',
                showCancelButton: true,
                confirmButtonText: 'Restablecer',
                cancelButtonText: 'Cancelar',
                focusConfirm: false,
                customClass: {
                    confirmButton: 'btn btn-primary mx-1',
                    cancelButton: 'btn btn-light mx-1'
                },
                buttonsStyling: false, // ← para usar clases personalizadas de Bootstrap
                inputAttributes: {
                    autocapitalize: 'off',
                    autocorrect: 'off'
                },
                inputValidator: (value) => {
                    if (!value) {
                        return 'Debe ingresar una contraseña';
                    }
                }
            }).then((result) => {
                if (result.isConfirmed && result.value) {
                    Livewire.emit('guardarNuevaPassword', result.value);
                }
            });
        });


        // Alerta de éxito
        window.addEventListener('msg-grabar', event => {
            Swal.fire({
                title: 'Buen Trabajo!',
                html: event.detail.newName,
                icon: 'success',
                confirmButtonClass: 'btn btn-primary w-xs mt-2',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.reload();
                }
            });
        });
       
        window.addEventListener('show-form', event => {
            $('#showModal').modal('show');
        })

        window.addEventListener('hide-form', event => {
            $('#showModal').modal('hide');
        })

        window.addEventListener('show-delete', event => {
            $('#deleteOrder').modal('show');
        })

        window.addEventListener('hide-delete', event => {
            $('#deleteOrder').modal('hide');
        })

        window.addEventListener('show-reintegrar', event => {
            $('#reintegrar').modal('show');
        })

        window.addEventListener('hide-reintegrar', event => {
            $('#reintegrar').modal('hide');
        })

        window.addEventListener('abrir-pdf', e => {
            window.open(e.detail.url, '_blank');
        });

    </script>
    
@endsection