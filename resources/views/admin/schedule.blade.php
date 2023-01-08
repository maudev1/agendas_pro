@extends('adminlte::page')

@section('title', 'Agendamento')

@section('content_header')
<h1>{{ $title }}</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">

        <div id="calendar"></div>

    </div>
</div>

<div class="row">
    <div class="col-md-12">

    </div>

</div>

@stop

@section('css')

@stop

@section('js')

<script src="/vendor/fullcalendar-6.0.1/dist/index.global.min.js"></script>

<script>

document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('calendar');
  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth'
  });
  calendar.render();
});

</script>

@stop