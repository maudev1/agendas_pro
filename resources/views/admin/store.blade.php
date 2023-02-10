@extends('adminlte::page')

@section('title', 'Clientes')

@section('content_header')
<h1>Loja</h1>
@stop

@section('content')

<hr>

<form method="POST" action="/admin/store">

@csrf

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>Razão Social</label>
                <input class="form-control" type="text" value="{{ $store->name ?? '' }}" name="name">


            </div>


        </div>

    </div>
    
    <div class="row">
        <div class="col-md-12">

        <div class="form-group">
                <label>Logo</label>
                <input class="form-control" type="file" name="logo">


            </div>


        </div>
    </div>

    <div class="row">
        <div class="col-md-12 text-right">

        <div class="form-group">

            <button class="btn btn-success" type="submit">Salvar</button>

        </div>


        </div>
    </div>
    

</div>

</form>


@stop

