@extends('adminlte::page')

@section('title', 'Clientes')

@section('content_header')
<h1>Clientes</h1>
@stop

@section('content')

<div class="row">
    <div class="col-md-12">
    @php 
    
        $headers = ['Nome', 'Telefone', 'Opções'] 
    
    @endphp
        <x-datatables :headers="$headers" :data="$customers"></x-datatables>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        @php

            $fields = [
                ['label' => 'Nome', 'field' => 'name'],
                ['label' => 'CPF', 'field' => 'cpf'],
                ['label' => 'Telefone', 'field' => 'phone'],
                ['label' => 'E-mail', 'field' => 'mail'],
                ['label' => 'Senha', 'field' => 'password'],
            ]
            
        @endphp

    </div>

</div>

    <x-modal :fields="$fields" ></x-modal>

@stop

@section('css')
<link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet">
@stop

@section('js')


<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.13.1/b-2.3.3/r-2.4.0/sb-1.4.0/datatables.min.js"></script>
<script src="{{asset('js/datatables.config.js')}}"></script>
<script src="{{asset('js/admin/Customer.js')}}"></script>

@stop