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
            Pase de Modalidad
        @endslot
    @endcomponent

    @livewire('vc-pass-course')

@endsection
@section('script')
    
    <!--ecommerce-customer init js -->
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>

    <script>
       
        window.addEventListener('show-form', event => {
            $('#showModalBuscar').modal('show');
        })

        window.addEventListener('hide-form', event => {
            $('#showModalBuscar').modal('hide');
        })

        window.addEventListener('msg-confirm', event => {
            
            Swal.fire({
                title: '¿Desea realizar cambio de Modalidad y Sección?',
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Grabar',
                cancelButtonText: 'No, cancel!',
                confirmButtonClass: 'btn btn-primary w-xs me-2 mt-2',
                cancelButtonClass: 'btn btn-danger w-xs mt-2',
                buttonsStyling: false,
                showCloseButton: true
            }).then(function (result) {
                if (result.value) {

                    Livewire.emit('setGrabar');

                } else if (
                    // Read more about handling dismissals
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    Swal.fire({
                    title: 'Cancelado',
                    text: 'Traslado no realizado...',
                    icon: 'error',
                    confirmButtonClass: 'btn btn-primary mt-2',
                    buttonsStyling: false
                    })
                }
            });

        })

        window.addEventListener('msg-grabar', event => {
            Swal.fire({
                    title: 'Buen Trabajo!',
                    text:  event.detail.newName,
                    icon: 'success',
                    confirmButtonClass: 'btn btn-primary w-xs mt-2',
                    buttonsStyling: false
                })
        })


    </script>
    
@endsection
