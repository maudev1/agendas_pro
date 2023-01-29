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

    @php

      $fields = [
        ['label' => 'Hora', 'field' => 'hora'],
        ['label' => 'Minuto', 'field' => 'minuto']
      ]

    @endphp

    </div>

</div>


<div class="row">
  <div class="col">
    <div>
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ $title }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">                  
                  <form id="modal-form" autocomplete="off">
                        <!-- <div  class="form-group text-right">
                          <a class="btn btn-danger"><i class="fas fa-trash danger"></i></a>
                    
                        </div> -->
                    
                        <div class="form-group">
                              <label for="customer">Titulo</label>
                              <input class="form-control" value="Agendamento Esporádico" id="title" name="title">
              
                        </div>
                        
                        <div class="form-group">
                              <label for="customer">Cliente</label>
                              <select class="form-control" id="customer">
                                <option value="">Escolha o cliente</option>

                                @foreach ($customers as $customer)
                                  <option value="{{$customer->id}}">{{$customer->name}}</option>
                                @endforeach
                            </select>
                            
                        </div>
                        
                        <div class="form-group ">
                          <label for="hour">Horário</label>
                          <input id="hour" class="form-control" name="hour">
                          <input id="start" class="form-control" type="hidden" name="start">
                          <input id="eventId" class="form-control" type="hidden" name="eventId">

                        </div>
                       
                        
                        <div class="form-check-inline">
                          <label class="form-check-label">
                            <input type="checkbox" id="notify" name="notify" class="form-check-input">
                            Notificar cliente

                            </label>

                        </div>
                    </form>

                    <hr>

                    <div id="preview"></div>

                </div>
                <div class="modal-footer row">
                  <div class="col text-left">
                    <a id="delete" style="display:none" class="btn btn-danger delete"><i class="fas fa-trash danger"></i></a>

                    
                  </div>
                  <div class="col text-right">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" id="save" class="btn btn-primary">Salvar</button>
                  </div>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div hidden style="position:fixed; bottom:0; right:10px" class="alert alert-success" role="alert">
  ola
</div>

@stop

@section('css')

<link rel="stylesheet" href="/vendor/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css"></link>

@stop

@section('js')

<script src="/js/moment.min.js"></script>

<script src="/vendor/fullcalendar-6.0.1/dist/index.global.min.js"></script>
<script src="/vendor/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<script src="/vendor/bootstrap-datetimepicker/js/demo.js"></script>
<script src="/js/calendar.config.js"></script>

@stop