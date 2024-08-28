<div class="row g-5">
    <div class="col-md-5 col-lg-4 order-md-last">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-primary">Serviços</span>
            <span id="service-quantity" class="badge bg-primary rounded-pill service-quantity"></span>
        </h4>
        <ul id="service-list" class="list-group mb-3">

        </ul>
    </div>
    <div class="col-md-7 col-lg-8">
        <h4 class="mb-3">Dados de Contato</h4>
        <form class="needs-validation" novalidate>
            <div class="row g-3">
                <div class="col-sm-12">
                    <div class="form-group form-floating">
                        <input type="text" class="form-control" name="customerName" id="customer-name">
                        <label for="customer-name" class="form-label">Nome Completo <span class="text-body-danger"> * </span></label>

                    </div>

                </div>

                <div class="col-sm-12">
                    <div class="form-group form-floating">
                        <input type="text" class="form-control phone" id="customer-phone" name="customerPhone">
                        <label for="customer-phone" class="form-label">Telefone <span class="text-body-danger"> * </span></label>

                    </div>


                </div>
            </div>

            <hr class="my-4">

            <h4 class="mb-3">Forma de Pagamento</h4>

            <div class="my-3">
                <div class="form-group">
                    <select class="form-control" name="payment_method" id="payment-method">
                        <option value="">Escolha</option>
                        <option value="1">PIX</option>
                        <option value="2">Cartão</option>
                        <option value="3">Dinheiro</option>
                    </select>


                </div>
            </div>

            <hr class="my-4">

            <div class="form-group text-center row">

                <div class="col col-sm-6 col-bg-6 text-left">
                    <button type="button" class="btn btn-lg btn-outline-dark flow-control" data-flow="2">
                        <!-- <i class="fas fa-chevron-left"></i> -->
                        Voltar
                    </button>
                </div>

                <div class="col col-sm-6 col-bg-6 text-right">
                    <button class="btn btn-lg btn-outline-success" type="submit">Confirmar</button>

                </div>

            </div>
        </form>
    </div>
</div>