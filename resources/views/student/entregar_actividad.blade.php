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
            
        @endslot
        @slot('title')
            
        @endslot
    @endcomponent

    @livewire('vc-deliver-activity',['id' => $id])

@endsection
@section('script')
    <!--ecommerce-customer init js -->

    
    <script src="{{ URL::asset('assets/libs/@ckeditor/@ckeditor.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>

        window.addEventListener('msg-grabar', event => {
            swal("Buen Trabajo!", event.detail.newName, "success");
        })

        window.addEventListener('entrega', event => {
            addElement(event.detail.newName)
        })

        document.addEventListener('DOMContentLoaded', function () {
            let editorInstance = null;

            document.getElementById('btnentrega').addEventListener('click', function () {
                const container = document.getElementById('editorContainer');
                
                // Mostrar el contenedor
                container.style.display = 'block';

                // Solo inicializar el editor si no ha sido creado aún
                if (!editorInstance) {
                    ClassicEditor
                        .create(document.querySelector('#editor'))
                        .then(function (editor) {
                            editorInstance = editor;

                            editor.model.document.on('change:data', () => {
                                Livewire.emit('updateEditorData', editor.getData());
                            });
                        })
                        .catch(error => {
                            console.error(error);
                        });
                }
            });
        });
        
        Livewire.on('setEditorData', (datosDelEditor) => {
            alert(datosDelEditor);
            const editor = ClassicEditor.instances['editor']; // Si tienes múltiples instancias, usa el selector correspondiente
            editor.setData(datosDelEditor);
        });
        
        function addElement($text)
        {
            var $string = $text
             document.getElementById("elemnt").innerHTML += $string;
        }

    </script>
    
@endsection