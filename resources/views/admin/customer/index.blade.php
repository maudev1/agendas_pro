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
        <x-datatables :headers="$headers" ></x-datatables>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        
    @include('admin.customer.create')
    
    @include('admin.customer.delete')

    </div>
</div>

@stop

@section('css')
<link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
@stop

@section('js')
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.13.1/b-2.3.3/r-2.4.0/sb-1.4.0/datatables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="/vendor/jquery/jquery.mask.js"></script>
<script src="/js/apply.masks.js"></script>
<script src="/js/HttpObserver.js"></script>
<script src="/js/HttpNotifier.js"></script>
<script src="/js/Customer.js"></script>

@stop