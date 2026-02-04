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
            Exámenes
        @endslot
        @slot('title')
            Crear Exámen Suplementario
        @endslot
    @endcomponent

    @livewire('vc-supletory-add',['id' => $id])

@endsection
@section('script')
    <!--ecommerce-customer init js -->

    
    <script src="{{ URL::asset('assets/libs/@ckeditor/@ckeditor.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/ecommerce-product-create.init.js') }}"></script>

    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>

    <script>
       
        window.addEventListener('msg-grabar', event => {
            /*swal("Buen Trabajo!", event.detail.newName, "success");*/
            Swal.fire({
            title: 'Buen Trabajo!',
            html:  event.detail.newName,
            icon: 'success',
            confirmButtonClass: 'btn btn-primary w-xs mt-2',
            confirmButtonText: 'OK'
            }).then((result) => {
            if (result.isConfirmed) {
                Livewire.emit('retornar'); // Actualiza la misma página
            }
            });
        })

        window.addEventListener('iniciar-descarga', event => {
            const url = event.detail.url;
            window.open(url, '_blank');
        });

        document.addEventListener('livewire:load', function () {
            ClassicEditor
                .create(document.querySelector('#editor'))
                .then(function(editor){
                    editor.model.document.on('change:data',()=> {
                        Livewire.emit('updateEditorData', editor.getData());
                    })
                })
                .catch(error => {
                    console.error(error);
                });
        })
        
        Livewire.on('setEditorData', (datosDelEditor) => {
            alert(datosDelEditor);
            const editor = ClassicEditor.instances['editor']; // Si tienes múltiples instancias, usa el selector correspondiente
            editor.setData(datosDelEditor);
        });

    </script>
    
@endsection
