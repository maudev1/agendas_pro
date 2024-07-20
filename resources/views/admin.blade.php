@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <p>Welcome to this beautiful admin panel.</p>
@stop

@section('css')
    <link rel="stylesheet" href="{{asset('css/admin_custom.css')}}">
@stop

@section('js')
    <script src="{{asset("vendor/jquery/jquery.mask.js")}}"></script>
    <script src="{{asset("js/apply.masks.js")}}"></script>
    <script src="{{asset('js/commons.js')}}"></script>



@stop