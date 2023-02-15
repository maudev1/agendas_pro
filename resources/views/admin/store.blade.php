@extends('adminlte::page')

@section('title', 'Clientes')

@section('content_header')
<h1>Loja</h1>
@stop

@section('content')

<hr>

<form method="POST" action="/admin/store/{{ $store->id ?? '' }}">

@csrf

<div class="container">
    <h3>Visual da Loja</h3>
    <div class="row">
        <div class="col">

            <div class="form-row  mb-2 mr-sm-2">

                <div class="col">
                    <label for="">Razão Social</label>
                    <input class="form-control" type="text" value="{{ $store->name ?? '' }}" name="name">
                    <small id="helpId" class="text-muted">Help text</small>

                </div>
                <div class="col">
                    <label>Slogan</label>
                    <input class="form-control" name="slogan" value="{{ $store->slogan ?? '' }}"  type="text"></div> 


                </div>
            </div>



        </div>
         
    </div>

</div>

<hr>
<div class="container">
    <h3>Atendimento</h3>

    <div class="row">
        <div class="col-md-12">
            <div class="form-row  mb-2 mr-sm-2">
                <div class="col">
                <label>Dia de funcionamento</label>
                <input class="form-control" type="date" value="{{ $store->work_days ?? '' }}" name="work_days">
                
            </div>
            <div class="col">
                <label>Horário de funcionamento</label>
                <input class="form-control" type="time" value="{{ $store->office_hour ?? '' }}" name="office_hour">

            </div>
            </div>
        </div>

    </div>
    
    <div class="row">
        <div class="col-md-12">

        <div class="form-group">
                <label>Logo</label>
                <input class="form-control" type="file" value="{{ $store->logo ?? 'none' }}" name="logo">


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

