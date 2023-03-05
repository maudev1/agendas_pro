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

        <x-modal :fields="$fields" :title="$title='Adicionar Cliente'" :text="$txt='Adicionar Cliente'"></x-modal>
    </div>

</div>

@stop

@section('css')
<link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet">
@stop

@section('js')


<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.13.1/b-2.3.3/r-2.4.0/sb-1.4.0/datatables.min.js"></script>
<script src="/js/datatables.config.js"></script>
<script src="/vendor/jquery/jquery.mask.js"></script>
<script src="/js/apply.masks.js"></script>
<script src="/js/HttpObserver.js"></script>
<script src="/js/HttpNotifier.js"></script>
<script src="/js/Customer.js"></script>

@stop