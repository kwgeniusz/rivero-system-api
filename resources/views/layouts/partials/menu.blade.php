

<!-- ESTA ES TODA LA BARRA AZUL SUPERIOR-->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional)
      <div class="user-panel">
        <div class="pull-left image">
          <img src="img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Alexander Pierce</p>

          <a href="#"><i class="fa fa-circle text-success"></i> Disponible</a>
        </div>
      </div>
    -->

      <!-- search form (Optional)
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Buscar...">
          <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
        </div>
      </form>
     .search form -->

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">{{__('Main Menu')}}</li>
        <!-- Optionally, you can add icons to the links -->

        <li class="active"><a href="{{route('home')}}"><i class="fa fa-home"></i> <span>{{__('Home')}}</span></a></li>

        <li class="treeview">
          <a href="#"><i class="fa fa-file-contract"></i> <span>{{__('Contracts')}}</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
           @if(Auth::user()->userLevel == 1)
            <li><a href="{{route('clients.index')}}"> {{__('clients')}}   </a></li>
            <li><a href="{{route('precontracts.index')}}">Pre-Contratos</a></li>
            <li><a href="{{route('contracts.index')}}">{{__('Contracts')}}</a></li>
            @endif
            @if(Auth::user()->userLevel == 1 or Auth::user()->userLevel == 4)
          <li><a href="{{route('contracts.generalSearch')}}">{{__('general_search')}}</a></li>
          @endif
          @if(Auth::user()->userLevel == 1)
          <li><a href="{{route('contracts.searchStatus')}}">{{__('contract_status')}}</a></li>
            <li><a href="{{route('contracts.finished')}}">{{__('contracts_finished')}}</a></li>
            <li><a href="{{route('contracts.cancelled')}}">{{__('contracts_cancelled')}}</a></li>
            <hr>
            @endif
        @if(Auth::user()->userLevel == 1 or Auth::user()->userLevel == 4)
            <li><a href="{{route('contracts.print')}}">{{__('print_contract')}}</a></li>
            <li><a href="{{route('contracts.summary')}}">{{__('contract_summary')}}</a></li>
            <li><a href="{{route('contracts.summaryForClient')}}">{{__('client_summary')}}</a></li>
          </ul>
          @endif
          @if(Auth::user()->userLevel == 1)
        </li>

        <li class="treeview">
          <a href="#"><i class="fa fa-address-card"></i> <span>{{__('administration')}}</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{route('transactionsTypes.index')}}">{{__('types_of_transactions')}}</a></li>
            <li><a href="{{route('transactions.index',['sign' => '+'])}}">{{__('income_transactions')}}</a></li>
            <li><a href="{{route('transactions.index',['sign' => '-'])}}">{{__('expenses_transactions')}}</a></li>
            <li><a href="{{route('banks.index')}}">{{__('bank')}}</a></li>
            <li><a href="{{route('receivables.index')}}">{{__('accounts_receivable')}}</a></li>
            <li><a href="#">{{__('debts_to_pay')}}</a></li>
            <hr>
            <li><a href="{{route('transactions.incomeexpenses')}}">{{__('income_and_expenses_report')}}</a></li>
            <li><a href="{{route('transactions.income')}}">{{__('income_report')}}</a></li>
            <li><a href="{{route('transactions.expenses')}}">{{__('expense_report')}}</a></li>
              <li><a href="{{route('collections.index')}}">Reporte de Cobranzas</a></li>
              <br>
          </ul>
        </li>

        <li class="treeview">
          <a href="#"><i class="fa fa-users"></i> <span>{{__('Human Resources')}}</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
              <li><a href="#">{{__('Type of Payroll')}}</a></li>
              <li><a href="#">{{__('Charges')}}</a></li>
              <li><a href="#">{{__('Type of Transactions')}}</a></li>
              <li><a href="#">{{__('periods')}}</a></li>
              <li><a href="#">{{__('personnel')}}</a></li>
              <li><a href="#">{{__('calculate_payroll')}}</a></li>
              <li><a href="#">{{__('calculate_special_payroll')}}</a></li>
              <li><a href="#">{{__('update_payroll')}}</a></li>
              <hr>
              <li><a href="#">{{__('payment_receipt')}}</a></li>
              <li><a href="#">{{__('payroll_list')}}</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#"><i class="fa fa-suitcase"></i> <span>{{__('Inventory')}}</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#">{{__('Equipment Registration')}}</a></li>
            <li><a href="#">{{__('Registration by Location')}}</a></li>
            <li><a href="#">{{__('Registration by Status')}}</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#"><i class="fa fa-wrench"></i> <span>{{__('Configuration')}}</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#">{{__('Countries')}}</a></li>
            <li><a href="#">{{__('Offices')}}</a></li>
            <li><a href="{{route('projects.index')}}">{{__('types_of_projects')}}</a></li>
            <li><a href="{{route('services.index')}}">{{__('types_of_services')}}</a></li>
            <li><a href="#">{{__('Users')}}</a></li>
          </ul>
        </li>

        <li>
          @endif
    <a href="{{ route('logout') }}"  onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
               <i class="fa fa-power-off"></i>
      <span>{{__('Sign Off')}}</span>
    </a>
    </li>
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>
