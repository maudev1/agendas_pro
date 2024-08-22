@extends('adminlte::page')

@section('title', 'Agendamento')

@section('content_header')
<h1>{{ $title }}</h1>
@stop

@section('content')

@section('css')

<link rel="stylesheet" href="/css/calendar.css">
</link>

@stop


<div class="row">
  <div class="col-md-12">

    <div id="calendar"></div>

  </div>
</div>

<div class="row">
  <div class="col-md-12">

    @php

    $fields = [
    ['label' => 'Hora', 'field' => 'hora'],
    ['label' => 'Minuto', 'field' => 'minuto']
    ]

    @endphp

  </div>

</div>

<input type="hidden" id="userId" value="{{ $userId }}">
<input type="hidden" id="office-hour-start" value="{{ $store->office_hour_start }}" >
<input type="hidden" id="office-hour-end"   value="{{ $store->office_hour_end }}" >

<div id="app" class="row">
  <div class="col">
    <div>
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <x-admin.schedule.confirmation-modal :products="$products" :customers="$customers">

      </x-admin.schedule.confirmation-modal>

      <x-admin.schedule.newScheduling :products="$products" :customers="$customers">

      </x-admin.schedule.newScheduling>
    </div>
  </div>
</div>

<!-- Share button -->

<x-sharebutton :link="$shareurl"></x-sharebutton>

@stop

@section('css')

<link rel="stylesheet" href="{{ asset('css/schedule.css') }}">


@endsection


@section('js')
<script src="{{ asset('js/moment.min.js') }}"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.min.js"></script>
<link rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css"
  integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
<script src="/vendor/fullcalendar-6.0.1/dist/index.global.min.js"></script>
<script src="/vendor/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<script src="/vendor/bootstrap-datetimepicker/js/demo.js"></script>
<script src="/js/admin/Schedule.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"
  integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>

@stop