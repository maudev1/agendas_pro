<!doctype html>
<html lang="pt-BR" class="h-100" data-bs-theme="auto">

<head>
  <script src="{{'js/color-modes.js'}}"></script>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.122.0">
  <title>Bolinho Barber</title>

  <!-- fontawesome -->
  <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">


  <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/cover/">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">

  <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>

  <!-- Custom styles for this template -->
  <link href="{{ asset('css/schedule.css') }}" rel="stylesheet">

  <!-- SweetAlert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<!-- <body class="d-flex h-100 text-center text-bg-dark"> -->

<body class="d-flex h-100 text-bg-dark">
  <!-- <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
    <symbol id="check2" viewBox="0 0 16 16">
      <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z" />
    </symbol>
    <symbol id="circle-half" viewBox="0 0 16 16">
      <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z" />
    </symbol>
    <symbol id="moon-stars-fill" viewBox="0 0 16 16">
      <path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z" />
      <path d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z" />
    </symbol>
    <symbol id="sun-fill" viewBox="0 0 16 16">
      <path d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z" />
    </symbol>
  </svg> -->

  <!-- <div class="dropdown position-fixed bottom-0 end-0 mb-3 me-3 bd-mode-toggle">
    <button class="btn btn-bd-primary py-2 dropdown-toggle d-flex align-items-center" id="bd-theme" type="button" aria-expanded="false" data-bs-toggle="dropdown" aria-label="Toggle theme (auto)">
      <svg class="bi my-1 theme-icon-active" width="1em" height="1em">
        <use href="#circle-half"></use>
      </svg>
      <span class="visually-hidden" id="bd-theme-text">Toggle theme</span>
    </button>
    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-text">
      <li>
        <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light" aria-pressed="false">
          <svg class="bi me-2 opacity-50" width="1em" height="1em">
            <use href="#sun-fill"></use>
          </svg>
          Light
          <svg class="bi ms-auto d-none" width="1em" height="1em">
            <use href="#check2"></use>
          </svg>
        </button>
      </li>
      <li>
        <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark" aria-pressed="false">
          <svg class="bi me-2 opacity-50" width="1em" height="1em">
            <use href="#moon-stars-fill"></use>
          </svg>
          Dark
          <svg class="bi ms-auto d-none" width="1em" height="1em">
            <use href="#check2"></use>
          </svg>
        </button>
      </li>
      <li>
        <button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="auto" aria-pressed="true">
          <svg class="bi me-2 opacity-50" width="1em" height="1em">
            <use href="#circle-half"></use>
          </svg>
          Auto
          <svg class="bi ms-auto d-none" width="1em" height="1em">
            <use href="#check2"></use>
          </svg>
        </button>
      </li>
    </ul>
  </div> -->


  <!-- <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column"> -->
  <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
    <header class="mb-3 mt-3 text-center">
      <div>
        <h3>Bolinho barber</h3>
        <!-- <nav class="nav nav-masthead justify-content-center float-md-end">
          <a class="nav-link fw-bold py-1 px-0 active" aria-current="page" href="#">Home</a>
          <a class="nav-link fw-bold py-1 px-0" href="#">Features</a>
          <a class="nav-link fw-bold py-1 px-0" href="#">Contact</a>
        </nav> -->
      </div>
    </header>

    <main class="px-3 te">

      <figure class="text-center">
        <img src="{{ asset('img/logo.jpeg') }}" alt="">
      </figure>

      <form id="date-form" action="post">

        <!-- User id -->
        @csrf

        <input type="hidden" name="user" value="{{ $encodedUserId }}">

        <div id="products-section" class="row">
          <div class="col-sm-12 col-md-12 col-bg-12">

            <label for="products">O que gostaria de fazer?</label>

            <div class="form-group mb-3 mt-3">

              <select class="form-control" name="products[]" id="products" multiple>
                <option value="">Clique para escolher</option>

                @foreach($products as $product)
                  

                  <option value="{{ $product->id }}">{{ $product->description }}</option>

                @endforeach

              </select>


            </div>

          </div>
        </div>

        <div id="date-changer-section" class="row">
          <div class="col col-sm-12 col-md-12 col-bg-12">
            <label for="date">Escolha uma data:</label>

            <div class="form-group mb-3 mt-3">
              <input class="form-control date" type="date" name="date" id="date" />

            </div>

            <div class="from-group mb-3 text-center">
              <button class="btn btn-outline-primary">Próximo

              <i class="fas fa-chevron-right"></i>

              </button>
            </div>

          </div>
        </div>



      </form>

      <form id="checkout-form" action="post">

        <!-- User id -->
        @csrf

        <!-- <input type="hidden" name="user" value="{{ $encodedUserId }}">

        <label for="">Escolha uma data:</label>

        <div class="form-group mb-3 mt-3">
          <input class="form-control date" type="date" name="date">

        </div> -->

        <div class="row" id="available-hours-section" style="display:none">
          <div class="col col-sm-12 col-md-12 col-bg-12">
            <label for="available-hours">Horários disponíveis:</label>
            <div class="from-group mb-3 mt-3">
              <select class="form-control" name="availableHours" id="available-hours"></select>

            </div>

            <div class="from-group mb-3 row">
              <div class="col col-sm-6 col-md-6 col-bg-12 text-center">
                <button type="button" class="btn btn-outline-primary" id="checkout-form-before">
                 
                <i class="fas fa-chevron-left"></i>
                  Voltar
                </button>

                <button type="button" class="btn btn-outline-primary" id="hours-form">Próximo

                <i class="fas fa-chevron-right"></i>

                </button>

              </div>
            </div>
          </div>
        </div>

        <div class="row" id="customer-details-section" style="display:none">
          <div class="col col-sm-12 col-md-12 col-bg-12 text-left">
            <label for="customer-name">Nome</label>
            <div class="form-group mt-3 mb-3 ">
              <input type="text" name="customerName" class="form-control" id="customer-name" value="Mauricio">
            </div>
            <label for="customer-phone">Celular</label>
            <div class="form-group mt-3 mb-3">
              <input type="text" name="customerPhone" class="form-control" id="customer-phone" value="11996502162">
            </div>
            <div class="from-group mb-3 text-center">
              <button type="button" class="btn btn-outline-primary" id="customer-details-before">
                <i class="fas fa-chevron-left"></i>
                   Voltar
              </button>

              <button type="submit" class="btn btn-outline-primary">
                Agendar 
                
                <i class="fas fa-check"></i>
              </button>
            </div>

          </div>
        </div>

        <div class="row" id="confirmation" style="display:none">
          <div class="col col-sm-12 col-md-12 col-bg-12 text-left">
            <div class="container">

              <p>Aguardando confirmação do salão...</p>


            </div>
          </div>
        </div>


      </form>



    </main>

    <footer class="mt-auto text-white-50">
      <!-- <p>Cover template for <a href="https://getbootstrap.com/" class="text-white">Bootstrap</a>, by <a href="https://twitter.com/mdo" class="text-white">@mdo</a>.</p> -->
    </footer>
  </div>

  <link rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css"
  integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />

  <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"
  integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>

  <script src="{{ asset('js/commons.js')}}"></script>
  <script src="{{ asset('js/Schedule.js')}}"></script>


</body>

</html>