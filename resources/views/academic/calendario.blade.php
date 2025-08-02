@extends('layouts.master')
@section('title') 
    @lang('translation.calendar') 
@endsection
@section('css')
    <link href="{{ URL::asset('/assets/libs/fullcalendar/fullcalendar.min.css') }}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1') 
            Apps
        @endslot
        @slot('title') 
            Calendar 
        @endslot
    @endcomponent

    @livewire('vc-calendario')

@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/fullcalendar/fullcalendar.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/calendar.js') }}"></script> 

    <script>

        window.addEventListener('show-event', event => {
            $('#view-event').modal('show');
        })
       
        window.addEventListener('show-form', event => {
            $('#event-modal').modal('show');
        })

        window.addEventListener('hide-form', event => {
            $('#event-modal').modal('hide');
        })

        function viewEvent(idEvent) {
            Livewire.emit('postAdded',idEvent);
        }

        function newEvent() {
            
            Livewire.emit('newEvent');
        }

        window.addEventListener('load-calendar', event => {
            var dataevent 
            dataevent = JSON.parse(event.detail.newObj);
            loadCalendar(dataevent);
        })

        
    </script>


@endsection