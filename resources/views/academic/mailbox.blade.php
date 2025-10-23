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
            Académico
        @endslot
        @slot('title')
            
        @endslot
    @endcomponent

    @livewire('vc-suggestion-box')

@endsection
@section('script')
    
    <!--ecommerce-customer init js -->
    <script src="{{ URL::asset('assets/libs/@ckeditor/@ckeditor.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>

    <script>

        window.addEventListener('msg-grabar', event => {
            /*swal("Buen Trabajo!", event.detail.newName, "success");*/
            Swal.fire({
            title: 'Comentario Enviado!',
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

        let editorInstance; // Variable global para guardar la instancia

        document.addEventListener('livewire:load', function () {
            ClassicEditor
                .create(document.querySelector('#editor'))
                .then(function (editor) {
                    editorInstance = editor; // ✅ Guardamos la instancia

                    // Cuando cambia el contenido, lo enviamos a Livewire
                    editor.model.document.on('change:data', () => {
                        Livewire.emit('updateEditorData', editor.getData());
                    });
                })
                .catch(error => {
                    console.error(error);
                });
        });

        // Cuando Livewire quiere establecer el contenido del editor
        Livewire.on('setEditorData', (datosDelEditor) => {
            if (editorInstance) {
                editorInstance.setData(datosDelEditor);
            } else {
                console.warn('El editor aún no está listo.');
            }
        });

    </script>
    
@endsection
