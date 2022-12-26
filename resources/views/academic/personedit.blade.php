@extends('layouts.master')
@section('title')
    @lang('translation.settings')
@endsection
@section('content')

    @livewire('vc-personadd',['tuition_id' => $id])

@endsection
@section('script')

    <script src="{{ URL::asset('assets/js/pages/profile-setting.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>    


@endsection