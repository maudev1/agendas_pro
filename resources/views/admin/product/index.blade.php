@extends('adminlte::page')

@section('title', 'Produtos')

@section('content_header')
<h1>Produtos</h1>
@stop

@section('content')

<div class="row">
    <div class="col-md-12">
    @php 
    
        $headers = ['Descrição', 'Valor', 'Disconto %', 'Opções'] 
    
    @endphp
        <x-datatables :headers="$headers" :data="$products"></x-datatables>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        @php

            $fields = [
                ['label' => 'Descrição', 'field' => 'description'],
                ['label' => 'Desconto', 'field' => 'discount'],
                ['label' => 'Valor', 'field' => 'price', 'class' => ['money']],
            ]
            
        @endphp

    </div>

</div>

    <x-admin.product.modal :fields="$fields" ></x-admin.product.modal>

@stop

@section('css')
<link href="https://cdn.datatables.net/2.0.2/css/dataTables.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/3.0.0/css/responsive.dataTables.min.css" rel="stylesheet">

<link href="{{asset('css/products.css')}}" rel="stylesheet">
@stop

@section('js')
<script type="text/javascript" src="https://cdn.datatables.net/2.0.2/js/dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/3.0.0/js/dataTables.responsive.min.js"></script>
<script src="{{asset('js/datatables.config.js')}}"></script>
<script src="{{asset('js/admin/Product.js')}}"></script>

@stop