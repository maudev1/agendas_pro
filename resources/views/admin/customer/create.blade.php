<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModaLabel" aria-hidden="true">
    <form id="modal-form" autocomplete="off">
        @csrf
        <!-- <meta name="csrf-token" content="{{ csrf_token() }}"> -->
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModaLabel">{{ $title ?? 'Adicionar novo cliente' }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert" role="alert"></div>

                    <div class="form-group">
                        <label>Nome</label>
                        <input id="name" class="form-control" name="name">
                    </div>

                    <div class="form-group">
                        <label>CPF</label>
                        <input id="cpf" class="form-control cpf-mask" name="cpf">
                    </div>

                    <div class="form-group">
                        <label>Telefone</label>
                        <input id="phone" class="form-control" name="phone">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="submit" id="save" class="btn btn-primary">Salvar</button>
                </div>
            </div>
        </div>
    </form>

</div>


<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createModal">
        Adicionar cliente
</button>