{{--  --}}

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
<!-- @can('A') -->
        <li class="active"><a href="{{route('home')}}"><i class="fa fa-home"></i> <span>{{__('Home')}}</span></a></li>
<!-- @endcan -->

   @can('B')
        <li class="treeview">
          <a href="#"><i class="fa fa-file-contract"></i> <span>{{__('Contracts')}}</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
  @can('BA') <li><a href="{{route('clients.index')}}"> {{__('clients')}}   </a></li> @endcan
  @can('BB') <li><a href="{{route('precontracts.index')}}">Pre-Contratos</a></li> @endcan
  @can('BD') <li><a href="{{route('contracts.index')}}">{{__('Contracts')}}</a></li> @endcan
  {{-- @can('BD') <li><a href="{{route('contracts.generalSearch')}}">{{__('general_search')}}</a></li> @endcan
  @can('BE') <li><a href="{{route('contracts.searchStatus')}}">{{__('contract_status')}}</a></li> @endcan --}}
  @can('BF') <li><a href="{{route('contracts.finished')}}">{{__('contracts_finished')}}</a></li> @endcan
  @can('BG') <li><a href="{{route('contracts.cancelled')}}">{{__('contracts_cancelled')}}</a></li> @endcan
            <hr>
  @can('BH')<li><a href="{{route('reports.summaryContractForCompany')}}">{{__('contract_summary')}}</a></li>@endcan
   <br>    
          </ul>
        </li>
@endcan
@can('C')
        <li class="treeview">
          <a href="#"><i class="fa fa-address-card"></i> <span>{{__('administration')}}</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
     {{-- @can('CA') <li><a href="{{route('transactionsTypes.index')}}">{{__('types_of_transactions')}}</a></li> @endcan --}}
     <!-- @can('BA') <li><a href="{{route('subcontractors.index')}}">Subcontratistas   </a></li> @endcan -->
     @can('CA') <li><a href="{{route('invoices.all')}}">Facturas</a></li> @endcan
     {{-- @can('CB') <li><a href="{{route('proposals.all')}}">Propuestas</a></li> @endcan --}}
     @can('CC') <li><a href="{{route('cashbox.transactions')}}">Caja</a></li> @endcan
     @can('CD') <li><a href="{{route('banks.transactions')}}">Bancos</a></li> @endcan
     @can('CE') <li><a href="{{route('transactions.index',['sign' => '+'])}}">{{__('income_transactions')}}</a></li> @endcan
     @can('CF') <li><a href="{{route('transactions.index',['sign' => '-'])}}">{{__('expenses_transactions')}}</a></li> @endcan
     @can('CG') <li><a href="{{route('payables.index')}}">   Cuentas Por Pagar</a></li> @endcan
     @can('CH') <li><a href="{{route('receivables.index')}}">Cuentas Por Cobrar</a></li> @endcan

<hr>
   @can('BI')<li><a href="{{route('contracts.summaryForClient')}}">Estado de Cuenta Por Cliente</a></li>
   @endcan   
     {{-- @can('CD') <li><a href="{{route('banks.index')}}">{{__('bank')}}</a></li> @endcan --}}
     {{-- @can('CF') <li><a href="#">{{__('debts_to_pay')}}</a></li> @endcan --}}
               {{--   <hr>
     @can('CG') <li><a href="{{route('transactions.incomeexpenses')}}">{{__('income_and_expenses_report')}}</a></li> @endcan
     @can('CH') <li><a href="{{route('transactions.income')}}">{{__('income_report')}}</a></li> @endcan
     @can('CI') <li><a href="{{route('transactions.expenses')}}">{{__('expense_report')}}</a></li> @endcan
     @can('CJ')  <li><a href="{{route('collections.index')}}">Reporte de Cobranzas</a></li> @endcan --}}
              <br>
          </ul>
        </li>
@endcan
@can('D')
        <li class="treeview">
          <a href="#"><i class="fa fa-users"></i> <span>{{__('Human Resources')}}</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
              <li><a href="{{route('departments.index')}}">Departamentos</a></li>
              <li><a href="{{route('charges.index')}}">{{__('Charges')}}</a></li>
              <li><a href="{{route('payroll_type.index')}}">{{__('Type of Payroll')}}</a></li>
              <li><a href="{{route('transactions_type.index')}}">{{__('Type of Transactions')}}</a></li>
              <li><a href="{{route('periods.index')}}">{{__('periods')}}</a></li>
              <li><a href="{{route('process.index')}}">Tipos de Procesos</a></li>
              <li><a href="{{route('staff.index')}}">{{__('personnel')}}</a></li>
              <li><a href="#">Cambios Generales de Salarios</a></li>
              <hr>
              <li><a href="#">Transacciones Fijas</a></li>
              <li><a href="#">Transacciones Variables</a></li>
              <li><a href="{{route('permanent-trans.index')}}">Transacciones Permanentes</a></li>
              <li><a href="{{route('payrollcontrol.index')}}">Carlcular Pre-nomina</a></li>
              <li><a href="{{route('printprepayroll.index')}}">Imprimir Pre-nomina</a></li>
              <li><a href="{{route('update-payroll.index')}}">Actualizar Nomina</a></li>
              <li><a href="{{route('print-payroll.index')}}">Imprimir Nomina</a></li>
              <li><a href="#">Generar Asientos Contables</a></li>
              {{-- <li><a href="#">{{__('update_payroll')}}</a></li>
              <li><a href="#">{{__('calculate_payroll')}}</a></li>
              <li><a href="#">{{__('calculate_special_payroll')}}</a></li> --}}
              <hr>
              <li><a href="#">Resumen de Trabajadores</a></li>
              <li><a href="#">Trabajadores Por Departamento</a></li>
              <li><a href="#">Expediente</a></li>
              <li><a href="#">Nomina de Pago</a></li>
              <li><a href="{{route('paycheck.index')}}">Recibo de Pago</a></li>
              {{-- <li><a href="#">{{__('payment_receipt')}}</a></li>
              <li><a href="#">{{__('payroll_list')}}</a></li> --}}
          </ul>
        </li>
@endcan
@can('E')        
        <li class="treeview">
          <a href="#"><i class="fa fa-donate"></i> <span>Contabilidad</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#">Tipo de Cuentas</a></li>
            <li><a href="#">Clasificacion de Cuentas</a></li>
            <li><a href="/accounting/general-ledgers">Plan de Cuentas</a></li>
            <li><a href="/accounting/transactions">Asientos Contables</a></li>
            <!-- <li><a href="#">Actualizar Asiento</a></li> -->
            <li><a href="#">Listado del plan de cuentas</a></li>
            <li><a href="#">Listado de transacciones</a></li>
            <li><a href="#">Actualizar transacciones</a></li>
            <hr>
            <li><a href="#">Balance de Comprobacion</a></li>
            <li><a href="#">Balance General</a></li>
            <li><a href="#">Estado de ganancias y perdidas</a></li>
            <br>
          </ul>
        </li>
@endcan
@can('E')        
        <li class="treeview">
          <a href="#"><i class="fa fa-suitcase"></i> <span>{{__('Inventory')}}</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
@can('FC')  <li><a href="{{route('services.index')}}">Servicios</a></li>@endcan 
            <li><a href="#">{{__('Equipment Registration')}}</a></li>
            <li><a href="#">{{__('Registration by Location')}}</a></li>
            <li><a href="#">{{__('Registration by Status')}}</a></li>
          </ul>
        </li>
@endcan
@can('F')        
        <li class="treeview">
          <a href="#"><i class="fa fa-wrench"></i> <span>{{__('Configuration')}}</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
@if(Auth::user()->changeCompany == 'Y')
          <li><a href="{{route('changeCompany.index')}}">Escoger Compañia</a></li>
@endif
@can('FA')<li><a href="{{route('company.index')}}">Empresas</a></li>       @endcan
{{-- @can('FB')  <li><a href="{{route('serviceTemplates.index')}}">Plantillas Para Factura</a></li>@endcan --}}
<li><a href="#">Correos</a></li> 
<li><a href="#">Telefonos</a></li> 
@can('FF')<li><a href="{{route('users.index')}}">{{__('Users')}}</a></li>  @endcan
          </ul>
        </li>
 @endcan
   <li>
    
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
