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
            Academico
        @endslot
        @slot('title')
            Calificar Exámenes
        @endslot
    @endcomponent

    @livewire('vc-qualify-exams')

@endsection
@section('script')
   

    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>

    <script>
       
        window.addEventListener('msg-confirm', event => {
            
            Swal.fire({
                title: '¿Desea guardar las calificaciones?',
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

                    Livewire.emit('setData');

                    /*Swal.fire({
                        title: 'Deleted!',
                        text: 'Your file has been deleted.',
                        icon: 'success',
                        confirmButtonClass: 'btn btn-primary w-xs mt-2',
                        buttonsStyling: false
                    })*/
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    Swal.fire({
                    title: 'Cancelado',
                    text: 'Calificaciones sin registrar...',
                    icon: 'error',
                    confirmButtonClass: 'btn btn-primary mt-2',
                    buttonsStyling: false
                    })
                }
            });

        })


        window.addEventListener('msg-alert', event => {
            swal("Error!", "No existen calificaciones para guardar", "warning");
        })    


        window.addEventListener('msg-grabar', event => {
            Swal.fire({
            title: 'Buen Trabajo!',
            html:  event.detail.newName,
            icon: 'success',
            confirmButtonClass: 'btn btn-primary w-xs mt-2',
            confirmButtonText: 'OK'
            }).then((result) => {
            if (result.isConfirmed) {
                location.reload(); // Actualiza la misma página
            }
            });
        })


    </script>
    
@endsection
