<div>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ $title }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                <div class="alert" role="alert"></div>

                    <form id="modal-form" autocomplete="off">

                        <input id="id" name="id" type="hidden">


                        @foreach($fields as $field)

                        <div class="form-group">
                            <label>{{ $field['label'] }} </label>
                            <input id="{{ $field['field'] }}" class="form-control" name="{{ $field['field'] }}">
                        </div>
                        
                        @endforeach
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" id="save" class="btn btn-primary">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Adicionar cliente
</button>

</div>