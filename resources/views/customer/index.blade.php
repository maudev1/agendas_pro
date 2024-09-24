<!doctype html>
<html lang="pt-BR" class="h-100" data-bs-theme="auto">

<head>

  <link rel="manifest" href="manifest.json">

  <meta name="mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="application-name" content="AgendasPro">
  <meta name="apple-mobile-web-app-title" content="AgendasPro">
  <meta name="theme-color" content="#0d6efd">
  <meta name="msapplication-navbutton-color" content="#0d6efd">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <meta name="msapplication-starturl" content="/">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


  <!-- Primary Meta Tags -->
  <meta name="title" content="{{ isset($store->name) ? $store->name : 'AgendasPro'  }}" />
  <meta name="description" content="Agenda seu atendimento em poucos segundos!" />

  <!-- Open Graph / Facebook -->
  <meta property="og:type" content="website" />
  <meta property="og:url" content="https://metatags.io/" />
  <meta property="og:title" content="{{ isset($store->name) ? $store->name : 'AgendasPro'  }}" />
  <meta property="og:description" content="Agenda seu atendimento em poucos segundos!" />
  <meta property="og:image" content="https://metatags.io/images/meta-tags.png" />

  <!-- Twitter -->
  <meta property="twitter:card" content="summary_large_image" />
  <meta property="twitter:url" content="https://metatags.io/" />
  <meta property="twitter:title" content="{{ isset($store->name) ? $store->name : 'AgendasPro'  }}" />
  <meta property="twitter:description" content="Agenda seu atendimento em poucos segundos!" />
  <meta property="twitter:image" content="https://metatags.io/images/meta-tags.png" />

  <!-- Meta Tags Generated with https://metatags.io -->


  <link rel="icon" type="img/png" sizes="500x500" href="img/2.png">
  <link rel="apple-touch-icon" type="img/png" sizes="500x500" href="img/2.png">


  <script src="{{asset('js/color-modes.js')}}"></script>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.122.0">
  <title>{{ isset($store->name) ? $store->name : 'AgendasPro'  }}</title>

  <!-- fontawesome -->
  <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">

  <!-- Safari ws comp-->
  <script async src="https://cdn.jsdelivr.net/npm/pwacompat@2.0.8/pwacompat.min.js" integrity="sha384-uONtBTCBzHKF84F6XvyC8S0gL8HTkAPeCyBNvfLfsqHh+Kd6s/kaS4BdmNQ5ktp1" crossorigin="anonymous"></script>

  <!-- main js -->

  <script src="{{ asset('js/push.js') }}"></script>
  <!-- <script src="{{ asset('js/main.js') }}"></script> -->


  <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/cover/">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">

  <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('vendor/jquery/jquery.mask.js') }}"></script>

  <!-- Custom styles for this template -->
  <link href="{{ asset('css/schedule.css') }}" rel="stylesheet">

  <!-- JQuery masks -->
  <script src="{{ asset('js/apply.masks.js') }}"></script>

  <!-- SweetAlert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<!-- <body class="d-flex h-100 text-center text-bg-dark"> -->

<body class="d-flex h-100 text-bg-dark">


  <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
    <header class="mb-3 mt-3 text-center">
      <div>
        <h3>{{ isset($store->name) ? $store->name : 'AgendasPro'  }}</h3>

      </div>
    </header>

    <main class="px-3" style="margin-bottom:200px">

      <figure class="text-center">
        <img src="{{ asset('img/logo.jpeg') }}" alt="">
      </figure>

      <form id="date-form" action="post">

        <!-- User id -->
        @csrf


        <input type="hidden" name="user" value="{{ $encodedUserId }}">

        <x-services :services="$services"></x-services>

      </form>

      <form id="checkout-form" action="post">

        <!-- User id -->
        @csrf

        <div id="available-hours-section" style="display:none">
          <x-timeavailable></x-timeavailable>

        </div>

        <div id="customer-details-section" style="display:none">

          <x-checkout></x-checkout>

        </div>

        <div id="confirmation" style="display:none">

          <div class="p-5 mb-4 bg-body-tertiary rounded-3">
            <div class="form-group mb-3 text-center">
              <p>Aguardando confirmação do salão...</p>

            </div>
            <div class="form-group mb-3 text-center">
              <x-spinner></x-spinner>


            </div>
            <hr>
            <div class="form-group mb-3 text-center">
              <button id="scheduling-cancel" class="btn btn-lg btn-outline-dark">Cancelar</button>

            </div>
          </div>
          <!-- <div class="row"> -->

          <!-- <div class="col-sm-12 col-md-12 col-bg-12 text-center">
              <div class="container"> -->


          <!-- </div> -->


          <!-- <span class="is-loading"></span> -->

          <!-- </div>

          </div> -->
          <!-- <div class="col-sm-12 col-md-12 col-bg-12 text-center">
            <a id="new-scheduling" onclick="schedule.toHome()" class="btn btn-primary">Novo Agendamento</a>

          </div> -->
        </div>

        <div class="row" id="confirmation-success" style="display:none">
          <div class="col col-sm-12 col-md-12 col-bg-12 text-center">
            <div class="container">

              <!-- <p><i class=" fas fa-check"></i> Atendimento confirmado!</p>



              <hr> -->

            </div>
          </div>
        </div>

      </form>

    </main>


    <footer class="mt-auto text-white-50">
      <!-- <p>Cover template for <a href="https://getbootstrap.com/" class="text-white">Bootstrap</a>, by <a href="https://twitter.com/mdo" class="text-white">@mdo</a>.</p> -->
    </footer>
  </div>

  <!-- <script src="{{asset('js/moment.min.js')}}"></script> -->
  <script src="{{asset('js/moment-with-locales.js')}}"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />

  <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>

  
  <!-- <script src="{{ asset('js/public_area/schedule.js') }}"></script> -->

  <script src="{{ asset('js/commons.js')}}"></script>
  <script src="{{ asset('js/Schedule.js')}}"></script>



</body>

</html>