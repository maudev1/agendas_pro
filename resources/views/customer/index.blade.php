<!doctype html>
<html lang="pt_br">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="form-validation.css" rel="stylesheet">

    <!-- HCaptcha -->
    <script src="https://js.hcaptcha.com/1/api.js?hl=fr" async defer></script>
  </head>

  <body class="bg-light">


    <!-- <div
  class="h-captcha"
  data-sitekey="bec2ccf1-9c68-4581-8ebe-9fe20e476737"
  data-theme="dark"
  data-hl="pt"
  data-error-callback="onError"
></div> -->



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
    <script src="/js/Schedule.js"></script>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="../../../../assets/js/vendor/popper.min.js"></script>
    <script src="../../../../dist/js/bootstrap.min.js"></script>
    <script src="../../../../assets/js/vendor/holder.min.js"></script> -->
    <script>
      // Example starter JavaScript for disabling form submissions if there are invalid fields
      (function () {
        'use strict';

        window.addEventListener('load', function () {
          // Fetch all the forms we want to apply custom Bootstrap validation styles to
          var forms = document.getElementsByClassName('needs-validation');

          // Loop over them and prevent submission
          var validation = Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
              if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
              }
              form.classList.add('was-validated');
            }, false);
          });
        }, false);
      })();
    </script>
  </body>

</html>