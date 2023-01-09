<div>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                <div class="alert" role="alert"></div>

                    <form id="modal-form" autocomplete="off">

                        <input id="id" name="id" type="hidden">

                        <div class="form-group">
                            <label>Nome</label>
                            <input id="name" class="form-control" name="name">
                        </div>

                        <div class="form-group">
                            <label>CPF</label>
                            <input id="cpf" class="form-control" name="cpf">
                        </div>
                        <div class="form-group">
                            <label>Telefone</label>
                            <input id="phone" class="form-control" name="phone">
                        </div>

                        <div class="form-group">
                            <label>E-mail</label>
                            <input id="mail" type="email" class="form-control"  name="mail">
                        </div>

                        <div class="form-group">
                            <label>Senha</label>
                            <input type="password" id="password" class="form-control" name="password">
                        </div>


                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" id="save" class="btn btn-primary">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <button type="button" data-toggle="modal" data-target="#exampleModal" class="btn btn-success">{{ $text
            }}</button>

    </div>

    <script>
        document.querySelectorAll('input').forEach(input => {

            console.log()

            input.value = ''
            
        });

    </script>

</div>