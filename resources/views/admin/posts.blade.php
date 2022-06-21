@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Dashboard</h1>
@stop

@section('content')

<div class="row">
    <div class="col-sm-12">

        <div class="form-group">
            <table width="100%" class="table">
                <thead>
                    <tr>
                        <th>Titulo</th>
                        <th>Data</th>
                        <th>Opções</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>Apenas um teste</th>
                        <th>29/03/2022</th>
                        <th><button class="btn btn-danger"><i class="fas fa-times"></i></button></th>
                    </tr>
                </tbody>

            </table>
        </div>
    </div>


</div>
<div class="row">
    <div class="col-sm-12">

        <form id="app">
            <button v-on:click='teste'> teste</button>
            <div class="form-group">

                <div id="editorjs">

                    <!-- <ckeditor v-model="editorData" :config="editorConfig"></ckeditor> -->

                </div>

            </div>
            <div class="form-group">
                <button v-on:click="sendForm()" type="button" class="btn btn-success">Postar</button>
            </div>

        </form>


    </div>
</div>




@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@push('scripts')

@endpush

@section('js')
<script src="https://cdn.jsdelivr.net/npm/@editorjs/editorjs@latest"></script>
<script src="{{asset('js/app.js')}}"></script>

<script>
    const editor = new EditorJS({
        /**
         * Id of Element that should contain Editor instance
         */
        holder: 'editorjs'
    });
</script>


@stop