<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>

    <!-- Styles -->
    @stack('styles')
    <link rel="shortcut icon" href="{{{ asset('img/favicon.ico') }}}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
   <!-- {{-- <link href="https://vjs.zencdn.net/7.6.0/video-js.css" rel="stylesheet"> --}} -->
  <!-- If you'd like to support IE8 (for Video.js versions prior to v7) -->

  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
<script type="text/javascript">
//pasando los permisos laravel a Vuejs
  @auth
    window.userPermissions = {!! json_encode(Auth::user()->allPermissions, true) !!};
  @else
    window.userPermissions = [];
  @endauth
//pasar el pais y oficina
    window.globalCountryId = {{session('countryId')}};
    window.globalCompanyId  = {{session('companyId')}};
    window.globalCompanyTimeZone  = {{session('companyTimeZone')}};
</script>
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-blue sidebar-mini ">
<div class="wrapper">
  
<div id="app">
 <!-- Main Header -->
   @include('layouts.partials.header')

  <!-- Left side column. contains the logo and sidebar -->
   @include('layouts.partials.menu')


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
       @include('layouts.partials.contentHeader')

    <!-- Main content -->
    <section class="content container-fluid">
      <!--------------------------
        | Your Page Content Here |
        -------------------------->
        @yield('content')
      
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
      @if (isset(Auth::user()->fullName))
        <strong>USUARIO: </strong>{{Auth::user()->fullName}} 
        <strong>PAIS: </strong>{{session('countryName')}} |
        <strong>COMPAÑIA: </strong>{{session('companyShortName')}}
      @else
        @php
          header("Location: " . URL::to('/login'), true, 302);
          exit();
        @endphp
      @endif
        
    </div>
    <!-- Default to the left -->
    @if (isset(Auth::user()->fullName))
    <strong>Copyright &copy; 2022 <a href="#">Rivero Global Company</a>.</strong> {{__('All Right Reserved')}}.
      
    @endif
  </footer>


   </div>
<!-- REQUIRED JS SCRIPTS -->
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/submit.js') }}"></script>
{{-- <script src="{{ asset('js/jspdf.js') }}"></script> --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
{{-- <script src='https://vjs.zencdn.net/7.6.0/video.js'></script> --}}
 <script>

  //Tooltip Boostrap 3.3
  $(function () { $('[data-toggle="tooltip"]').tooltip()});

  // Instancia de Input date libreria Flatpickr
  @if(session('countryId') == '1')
     flatpickr('.flatpickr', {
      altInput: true,
      minDate: '1920-01-01',
      locale: 'es',
      altFormat: 'm/d/Y',
      dateFormat: "Y-m-d",
    });
  @elseif(session('countryId') == '2')
      flatpickr('.flatpickr', {
      altInput: true,
      minDate: '1920-01-01',
      locale: 'es',
      altFormat: 'd/m/Y',
      dateFormat: "Y-m-d",
    });
  @endif

  $('.table-responsive').on('show.bs.dropdown', function () {
  $('.table-responsive').css( "overflow", "inherit" );
});

$('.table-responsive').on('hide.bs.dropdown', function () {
  $('.table-responsive').css( "overflow", "auto" );
})


 // muestra notificaciones de alerta
    @if(Session::has('message'))
        var type = "{{ Session::get('alert-type', 'info') }}";
        switch(type){
            case 'info':
                toastr.info("{{ Session::get('message') }}");
                break;
            case 'warning':
                toastr.warning("{{ Session::get('message') }}");
                break;
            case 'success':
                toastr.success("{{ Session::get('message') }}");
                break;
            case 'error':
                toastr.error("{{ Session::get('message') }}");
                break;
        }
    @endif
   </script>
 </div>
</body>
</html>
