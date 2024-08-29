@extends('adminlte::page')

@section('title', 'Usuários')

@section('content_header')
<h1>Usuários</h1>
@stop

@section('content')

<div class="row">
    <div class="col-md-12">
        @php

        $headers = ['Nome','E-mail','Telefone','Opções']

        @endphp
        <x-datatables :headers="$headers"></x-datatables>
    </div>
</div>


@php



@endphp

<x-admin.user.modal :fields="$fields" :roles="$roles"></x-admin.user.modal>

@stop

@section('css')
<link href="https://cdn.datatables.net/2.0.2/css/dataTables.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/3.0.0/css/responsive.dataTables.min.css" rel="stylesheet">
@stop

@section('js')

<script type="text/javascript" src="https://cdn.datatables.net/2.0.2/js/dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/3.0.0/js/dataTables.responsive.min.js"></script>
<script src="{{asset('js/datatables.config.js')}}"></script>
<script src="{{asset('js/admin/User.js')}}"></script>


@stop