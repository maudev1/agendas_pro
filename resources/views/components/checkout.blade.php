<div class="row g-5">
    <div class="col-md-5 col-lg-4 order-md-last">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-primary">Serviços</span>
            <span class="badge bg-primary rounded-pill">3</span>
        </h4>
        <ul id="service-list" class="list-group mb-3">
            <!-- <li class="list-group-item d-flex justify-content-between lh-sm">
                <div>
                    <h6 class="my-0">Product name</h6>
                    <small class="text-body-secondary">Brief description</small>
                </div>
                <span class="text-body-secondary">$12</span>
            </li>
            <li class="list-group-item d-flex justify-content-between lh-sm">
                <div>
                    <h6 class="my-0">Second product</h6>
                    <small class="text-body-secondary">Brief description</small>
                </div>
                <span class="text-body-secondary">$8</span>
            </li>
            <li class="list-group-item d-flex justify-content-between lh-sm">
                <div>
                    <h6 class="my-0">Third item</h6>
                    <small class="text-body-secondary">Brief description</small>
                </div>
                <span class="text-body-secondary">$5</span>
            </li>
            <li class="list-group-item d-flex justify-content-between bg-body-tertiary">
                <div class="text-success">
                    <h6 class="my-0">Promo code</h6>
                    <small>EXAMPLECODE</small>
                </div>
                <span class="text-success">−$5</span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
                <span>Total (USD)</span>
                <strong>$20</strong>
            </li> -->
        </ul>

        <!-- <form class="card p-2">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Promo code">
                <button type="submit" class="btn btn-secondary">Redeem</button>
            </div>
        </form> -->
    </div>
    <div class="col-md-7 col-lg-8">
        <h4 class="mb-3">Dados de Contato</h4>
        <form class="needs-validation" novalidate>
            <div class="row g-3">
                <div class="col-sm-12">
                    <label for="firstName" class="form-label">Nome Completo <span class="text-body-danger"> * </span></label>
                    <input type="text" class="form-control" name="customerName" id="customer-name" placeholder="" value="" required>

                </div>

                <div class="col-12">
                    <label for="email" class="form-label">Telefone <span class="text-body-danger"> * </span></label>
                    <input type="text" class="form-control phone" id="customer-phone" name="customerPhone" >


                </div>
            </div>

            <hr class="my-4">

            <h4 class="mb-3">Forma de Pagamento</h4>

            <div class="my-3">
                <div class="form-check">
                    <input id="credit" name="paymentMethod" type="radio" class="form-check-input" checked required>
                    <label class="form-check-label" for="credit">Cartão</label>
                </div>
                <div class="form-check">
                    <input id="debit" name="paymentMethod" type="radio" class="form-check-input" required>
                    <label class="form-check-label" for="debit">PIX</label>
                </div>
                <div class="form-check">
                    <input id="paypal" name="paymentMethod" type="radio" class="form-check-input" required>
                    <label class="form-check-label" for="paypal">Dinheiro</label>
                </div>
            </div>

            <hr class="my-4">

            <button class="w-100 btn btn-primary btn-lg" type="submit">Confirmar</button>
        </form>
    </div>
</div>