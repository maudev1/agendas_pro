<div class="modal fade" id="newScheduling" tabindex="-1" role="dialog" aria-labelledby="newSchedulingLabel"
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

                <input id="eventId" class="form-control" type="hidden" name="eventId">
                <form id="modal-form" autocomplete="off">

                    <div id="alert" class="alert" style="display:none"></div>


                    <div class="form-group">
                        <label for="customer">Descrição</label>
                        <input class="form-control" value="Agendamento Esporádico" id="title" name="title">

                    </div>

                    <!-- <hr> -->

                    <!-- <div class="form-group">

                         <label for="">Selecionar Cliente</label> 
                         <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="new-customer-switch">
                            <label class="form-check-label" for="new-customer-switch">Novo Cliente</label>
                        </div> 

                    </div> -->

                    <div class="form-group customer">
                        <label for="">Selecionar Cliente</label>

                        <select class="form-control" id="customer">
                            <option value="">Qual é o cliente?</option>

                            @foreach ($customers as $customer)
                            <option value="{{$customer->id}}">{{$customer->name}}</option>
                            @endforeach
                        </select>


                    </div>

                    <div class="form-group new-customer" style="display: none;">
                        <label for="customer-name">Nome do Cliente</label>
                        <input type="text" name="customerName" class="form-control" id="customer-name">

                    </div>


                    <div class="form-group">
                        <label for="product">Produtos</label>

                        <select name="products[]" id="products" multiple>
                            <option value="">Escolha</option>

                            @foreach($products as $product)

                            <option value="{{$product->id}}">{{ $product->description }}</option>

                            @endforeach

                        </select>

                    </div>

                    <div class="form-group">
                        <label for="payment-method">Método de Pagamento</label>
                        <select class="form-control" name="payment_method" id="payment-method">
                            <option value="">Escolha</option>
                            <option value="1">PIX</option>
                            <option value="2">Cartão</option>
                            <option value="3">Dinheiro</option>
                            <option value="4">Cortesia</option>
                        </select>


                    </div>

                    <input id="start" class="form-control" type="hidden" name="start">


                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <!-- <input type="checkbox" id="notify"  name="notify" class="form-check-input"> -->
                            <!-- Notificar cliente -->

                        </label>

                    </div>
                </form>

                <!-- <hr> -->

            </div>
            <div class="modal-footer row">
                <div class="col text-left">
                    <a id="delete" style="display:none" class="btn btn-danger delete"><i
                            class="fas fa-trash danger"></i></a>


                </div>
                <div class="col text-right">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" id="save" class="btn btn-primary">Salvar</button>
                </div>
            </div>
        </div>
    </div>
</div>