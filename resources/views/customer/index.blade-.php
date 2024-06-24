<!doctype html>
<html lang="pt_br">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'AgendasPro') }}</title>

    
    <!-- Bootstrap -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="form-validation.css" rel="stylesheet">

    <!-- HCaptcha -->
    <script src="https://js.hcaptcha.com/1/api.js?hl=fr" async defer></script>
    
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    
    <!-- Scripts -->
    
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/commons.js') }}"></script>


  </head>

  <body class="bg-light">

    <div class="container">
      <div class="py-5 text-center">
        <img class="d-block mx-auto mb-4" src="https://img.logoipsum.com/235.svg" alt="" width="130" height="72">
        <h2>Agenda {{ $store->name ?? ''}}</h2>
        <p class="lead"></p>
      </div>

      <div class="row">
        <div class="col-md-12 order-md-1">
          <h4 class="mb-3">Escolha uma data:</h4>
          <!-- <form class="needs-validation" novalidate> -->

          <hr class="mb-4">

          <div class="d-block my-3">


            <div id="calendar"> </div>

          </div>

          <hr class="mb-4">
          <!-- <button class="btn btn-primary btn-lg btn-block" type="submit">Continue to checkout</button> -->
          <!-- </form> -->
        </div>
      </div>

      <div id="app" class="row">
  <div class="col">
    <div>
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="preview"></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <input id="eventId" class="form-control" type="hidden" name="eventId">
              <form id="modal-form" autocomplete="off">

                <div id="alert" class="alert" style="display:none"></div>


                <div class="form-group">
                  <label for="customer">Titulo</label>
                  <input class="form-control" value="Agendamento Esporádico" id="title" name="title">

                </div>

                <!-- <hr> -->

                <div class="form-group new-customer mb-3">
                  <label for="customer-name">Seu Nome</label>
                  <input type="text" name="customerName" class="form-control" id="customer-name">

                </div>


                <div class="form-group mb-3">
                  <label for="product">Produtos</label>

                  <select class="form-control" name="products[]" id="products" multiple>
                    <option value="" >Escolha</option>

                    @foreach($products as $product)
                    
                      <option value="{{$product->id}}">{{ $product->description }}</option>
                    
                    @endforeach
                  
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
    </div>
  </div>
</div>

      <footer class="my-5 pt-5 text-muted text-center text-small">
        <p class="mb-1">&copy; 2017-2018 Company Name</p>
        <ul class="list-inline">
          <li class="list-inline-item"><a href="#">Privacy</a></li>
          <li class="list-inline-item"><a href="#">Terms</a></li>
          <li class="list-inline-item"><a href="#">Support</a></li>
        </ul>
      </footer>
    </div>

    <script src="/js/moment.min.js"></script>
    <script src="/vendor/fullcalendar-6.0.1/dist/index.global.min.js"></script>
    
    <script src="/js/admin/Schedule.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"
  integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="../../../../assets/js/vendor/popper.min.js"></script>
    <script src="../../../../dist/js/bootstrap.min.js"></script>
    <script src="../../../../assets/js/vendor/holder.min.js"></script> -->
  </body>

</html>