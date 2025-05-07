@extends('layouts.master')
@section('title')
    @lang('translation.settings')
@endsection
@section('content')

    @livewire('vc-personadd',['tuition_id' => $id])

@endsection
@section('script')

    <script src="{{ URL::asset('assets/js/pages/profile-setting.init.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{ URL::asset('assets/js/pages/personal-add.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>    

    <script>
       
        window.addEventListener('show-form', event => {
            $('#showModal').modal('show');
        })

        window.addEventListener('hide-form', event => {
            $('#showModal').modal('hide');
        })

        window.addEventListener('family-msg', event => {
            swal("Error!", "Datos del familiar no deben estar vacios..", "warning");
            document.getElementById('pills-bill-family-tab').click()
        })

        window.addEventListener('active-tab', event => {
            document.getElementById('pills-bill-family-tab').click()
        })

        window.addEventListener('family-add', event => {
           familyData();         
        })

        window.addEventListener('msg-actualizar', event => {
            swal("Good job!", "Record updated successfully!", "success");
        })

        window.addEventListener('msg-error', event => {
            swal("Error!", event.detail.newName, "warning");
        })
        
    </script>

@endsection