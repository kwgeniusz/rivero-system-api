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
    <link rel="shortcut icon" href="{{{ asset('img/favicon.jpg') }}}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">

   <link href="https://vjs.zencdn.net/7.6.0/video-js.css" rel="stylesheet">
  <!-- If you'd like to support IE8 (for Video.js versions prior to v7) -->
   <script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>

  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>

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
        <div id="app">
        @yield('content')
        
{{--           <video id='my-video' class='video-js' controls preload='auto' width='640' height='264'
   data-setup='{}'>
    <source src='{{ asset('m.mov') }}' type="video/quicktime">
    <source src='MY_VIDEO.webm' type='video/webm'>
    <source src="D:/mov1.mov" type="video/mp4"> 
    <p class='vjs-no-js'>
      To view this video please enable JavaScript, and consider upgrading to a web browser that
      <a href='https://videojs.com/html5-video-support/' target='_blank'>supports HTML5 video</a>
    </p>
  </video> --}}
        </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->




  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
        <strong>USUARIO: </strong>{{Auth::user()->fullName}} |
        <strong>PAIS: </strong>{{session('countryName')}} |
        <strong>OFICINA: </strong>{{session('officeName')}}
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2020 <a href="#">Rivero Global Company</a>.</strong> {{__('All Right Reserved')}}.
  </footer>


<!-- REQUIRED JS SCRIPTS -->

<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/submit.js') }}"></script>
<script src='https://vjs.zencdn.net/7.6.0/video.js'></script>
 <script>

  //Tooltip Boostrap 3.3
  $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
  // Instancia de Input date libreria Flatpickr
  @if(session('countryId') == '1')
     flatpickr('.flatpickr', {
      minDate: '1920-01-01',
      locale: 'es',
      dateFormat: "m/d/Y",
    });
  @elseif(session('countryId') == '2')
      flatpickr('.flatpickr', {
      minDate: '1920-01-01',
      locale: 'es',
      dateFormat: "d/m/Y",
    });
  @endif
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

</body>
</html>
