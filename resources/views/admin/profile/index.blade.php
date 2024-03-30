@extends('adminlte::page')

@section('title', 'Perfis')

@section('content_header')
<h1>Perfis</h1>
@stop

@section('content')

<div class="row">
    <div class="col-md-12">
        @php

        $headers = ['Descrição','Opções']

        @endphp
        <x-datatables :headers="$headers"></x-datatables>
    </div>
</div>


@php

$fields = [
    ['label' => 'Descrição', 'field' => 'description'],
]

@endphp

<x-admin.profile.modal :fields="$fields"></x-admin.profile.modal>

@stop

@section('css')
<link href="https://cdn.datatables.net/2.0.2/css/dataTables.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/3.0.0/css/responsive.dataTables.min.css" rel="stylesheet">
@stop

@section('js')

<script type="text/javascript" src="https://cdn.datatables.net/2.0.2/js/dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/3.0.0/js/dataTables.responsive.min.js"></script>
<script src="{{asset('js/datatables.config.js')}}"></script>
<script src="{{asset('js/admin/Profile.js')}}"></script>


@stop