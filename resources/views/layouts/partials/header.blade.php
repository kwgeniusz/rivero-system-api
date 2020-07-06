

<!-- ESTA ES TODA LA BARRA AZUL SUPERIOR-->

  <!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    <span  class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>RGC</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg "><b>JD {{session('officeName')}}</b></span>
    </span>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top " role="navigation">
      <!-- Sidebar toggle button | duplicated fixed -->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
               <li><a href="{{ route('localization',['language' => 'es']) }}">{{__('Spanish')}}</a></li>
               <li><a href="{{ route('localization',['language' => 'en']) }}">{{__('English')}}</a></li>



          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->

            <ul class="dropdown-menu">
              <!-- The user image in the menu -->

              <!-- Menu Body
              <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Seguidores</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Ventas</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Amigos</a>
                  </div>
                </div>
                /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">{{__('Profile')}}</a>
                </div>
                <div class="pull-right">
                    <a href="{{ route('logout') }}" class="btn btn-default btn-flat"
                    onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                      {{__('Sign Off')}}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>

                </div>
              </li>
            </ul>
          </li>

          <!-- Control Sidebar Toggle Button -->
         <!-- <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li> -->
        </ul>
      </div>
    </nav>
  </header>
