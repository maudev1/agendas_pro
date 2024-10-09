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
<input type="hidden" id="office-hour-start" value="{{ isset($store->office_hour_start) ? $store->office_hour_start : NULL  }}" >
<input type="hidden" id="office-hour-end"   value="{{ isset($store->office_hour_end)   ? $store->office_hour_end : NULL }}" >

<div id="app" class="row">
  <div class="col">
    <div>
      <meta name="csrf-token" content="{{ csrf_token() }}">

        <x-admin.schedule.confirmation-modal 
        :products="$products" 
        :customers="$customers">
        </x-admin.schedule.confirmation-modal>

        <x-admin.schedule.manual-scheduling 
        :products="$products" 
        :customers="$customers">
        </x-admin.schedule.manual-scheduling>

    </div>
  </div>
</div>

<!-- Share button -->

<x-sharebutton :link="$shareurl"></x-sharebutton>

@stop

@section('css')

<link rel="stylesheet" href="{{ asset('css/schedule.css') }}">

@endsection

<link rel="stylesheet" href="{{ asset('css/selectize.bootstrap3.min.css') }}" />

@section('js')
<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{ asset('js/moment-with-locales.js') }}"></script>
<!-- <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.min.js"></script> -->

<script src="{{ asset('vendor/fullcalendar-6.0.1/dist/index.global.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap-datetimepicker/js/demo.js') }}"></script>
<script src="{{ asset('js/admin/Schedule.js') }}"></script>
<!-- <script src="{{ asset('js/selectize.js') }}"></script> -->


<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"
  integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>

@stop