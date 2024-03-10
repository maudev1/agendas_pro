<div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form id="modal-form" autocomplete="off">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ $title ?? "Adicionar novo cliente" }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert" role="alert"></div>
                        <input id="id" name="id" type="hidden">

                        @foreach($fields as $field)

                        <div class="form-group">
                            <label>{{ $field['label'] }} </label>
                            <input id="{{ $field['field'] }}" class="form-control" name="{{ $field['field'] }}">
                        </div>

                        @endforeach

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="submit" id="save" class="btn btn-primary">Salvar</button>
                    </div>
                </div>
            </div>
    </div>
    </form>
</div>

<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog" role="document">
        <form id="confirm-form" >
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Atenção!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- <div class="alert" role="alert"></div> -->
                    <input id="customer-id" type="hidden">

                    <p>Deseja excluir esse registro?</p>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="submit" id="delete-confirm" class="btn btn-danger">Confirmar</button>
                </div>
            </div>
        </form>
    </div>

</div>

<button type="button" class="btn btn-primary" data-toggle="modal" data-type="insert" data-target="#exampleModal">
    Adicionar cliente
</button>

</div>