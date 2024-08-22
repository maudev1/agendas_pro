<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title preview"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div id="scheduling-data" class="card">
                            <div class="card-header">
                                <i class="fas fa-user"></i> <strong>
                                    Dados do Cliente
                                </strong>
                            </div>

                            <div class="personal-data card-body">

                            </div>

                            <hr>
                            <div class="card-header">
                                <i class="fas fa-receipt"></i> <strong>
                                    Serviços
                                </strong>
                            </div>

                            <div class="services-data card-body">
                                <table class="table">
                                    <thead>
                                        <tr>

                                            <th>Descrição</th>
                                            <th>Quantidade</th>
                                            <th>Valor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            
                                            <td>Corte de Cabelo Simples</td>
                                            <td class="text-center">1</td>
                                            <td>R$ 25,00</td>
                                        </tr>

                                        <tr>
                                            <td class="text-right"  colspan="3">
                                               <strong>Total:</strong> R$ 25,00
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>


                        </div>


                    </div>
                </div>




            </div>
            <div class="modal-footer row">
                <div class="col text-left">
                    <a id="delete" style="display:none" class="btn btn-danger delete"><i
                            class="fas fa-trash danger"></i></a>


                </div>
                <div class="col text-right">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button id="confirm" type="button" data-id="" class="btn btn-success confirmation">Confirmar</button>
                    <!-- <button type="button" id="save" class="btn btn-primary">Salvar</button> -->
                </div>
            </div>
        </div>
    </div>
</div>