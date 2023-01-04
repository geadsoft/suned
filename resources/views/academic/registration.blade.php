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
            Academic
        @endslot
        @slot('title')
            Student Enrollment
        @endslot
    @endcomponent

    @livewire('vc-student-enrollment',['tuition_id' => $id])

@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/list.js/list.js.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/list.pagination.js/list.pagination.js.min.js') }}"></script>
    
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{ URL::asset('assets/js/pages/academic-enrollment.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>

    <script>
       
        window.addEventListener('show-message', event => {
            $('#messageModal').modal('show');
        })

        window.addEventListener('msg-validanui', event => {
            swal("Error!", "Número de identificación ya Existe...", "warning");
             document.getElementById("txtnui").value = "";
        })

        window.addEventListener('msg-grabar', event => {
            swal("Good job!", "Record recorded successfully!", "success");
        })

        window.addEventListener('searchData', event => {
            selecTab('pills-bill-students');
        })    
        
        window.addEventListener('get-data', event => {

            var periodoId = document.getElementById("cmbperiodoId").value;
            var grupoId = document.getElementById("cmbgrupoId").value;
            var nivelId = document.getElementById("cmbnivelId").value;
            var gradoId = document.getElementById("cmbgradoId").value;
            var cursoId = document.getElementById("cmbcursoId").value;
            var personaId = document.getElementById("txtpersonaid").value;
            var new_registro = [];
            var new_persona  = [];

            var perid = document.getElementById("txtpersonaid").value;
            var pernomb = document.getElementById("pernombres").value;
            var perapel = document.getElementById("perapellidos").value;
            var pertipo = document.getElementById("pertipoident").value;
            var periden = document.getElementById("perident").value;
            var pergene = document.getElementById("pergenero").value;
            var pernaci = document.getElementById("pernacionalidad").value;
            var pertelf = document.getElementById("pertelefono").value;
            var perrelc = document.getElementById("perrelacion").value;
            var peremail = document.getElementById("peremail").value;
            var perdirec = document.getElementById("perdireccion").value;
                            
            var registro = {
                periodoid: periodoId,
                grupoid: grupoId,
                nivelid: nivelId,
                gradoid: gradoId,
                cursoid: cursoId,
                personaid: personaId,
            }
            new_registro.push(registro);

            var persona = {
                idpersona: perid,
                nombres: pernomb,
                apellidos: perapel,
                tipo: pertipo,
                identidad: periden,
                genero: pergene,
                nacion: pernaci,
                telefono: pertelf,
                relacion: perrelc,
                email: peremail,
                direccion: perdirec,
            }
            new_persona.push(persona);

            Livewire.emit('postAdded',new_registro, new_persona);
        
        })

        

    </script>
    
@endsection