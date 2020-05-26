@extends('layouts.master')

@section('content')
{{-- @php use AppApp\Receivable; @endphp --}}
<div class="col-xs-12 ">
<div class="panel panel-default col-xs-12">
    <div class="panel-body">

<div class="text-center"><h4 ><b>DETALLES DE FACTURA</b></h4></div>
 <div class="table-responsive">
            <table class="table table-striped table-bordered text-center ">
            <thead>
                <tr class="bg-success">
                 <th>N° FACTURA</th>
                 <th>CONTRATO</th>
                 <th>CLIENTE</th>
                 <th>DIRECCIÓN</th>
                 <th>FECHA</th>
                 <th>SUB-TOTAL</th>
                 <th>IMPUESTO</th>
                 <th>TOTAL</th>
                 <th>CUOTAS</th>
                 </th>
                </tr>
            </thead>
          <tbody>
                <tr>
                    <td>{{$invoice[0]->invId}} </td>
                    <td>{{$invoice[0]->contract->contractNumber}} </td>
                    <td>{{$invoice[0]->client->clientName}} </td>
                    <td>{{$invoice[0]->contract->siteAddress}} </td>
                    <td>{{$invoice[0]->invoiceDate}} </td>
                    <td>{{$invoice[0]->grossTotal }} </td>
                    <td>{{$invoice[0]->taxAmount }} </td>
                    <td>{{$invoice[0]->netTotal }} </td>
                    <td>{{$invoice[0]->pQuantity }} </td>
                </tr>
        </tbody>
      </table>
     </div>

     <hr>
     <h4 class="text-center"><b>CUOTAS</b></h4>
  <div class="col-lg-offset-3 col-lg-5 ">
        @if ($errors->any())
          <div class="alert alert-danger">
              <h4>Errores:</h4>
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif
        </div>

    <div class="row text-center">
      <form class="form-inline" action="{{Route('invoices.paymentsAdd')}}" method="POST">
      {{csrf_field()}}
        <input type="hidden" name="invoiceId" value="{{$invoice[0]->invoiceId}}">

         <div class="form-group col-lg-12  col-xs-12">
            <label for="amount" >MONTO</label>
              <input type="number" min='0.01' step="0.01" class="form-control" id="amount" name="amount" required autocomplete="off">
         </div>
       <br><br>
        <div class="form-group  col-lg-12  col-xs-12"> 
           <button type="submit" class="btn btn-success">
                 <span class="fa fa-plus" aria-hidden="true"></span>
                 Agregar Cuota
            </button>
        </div>

        </form>
    </div>


        <br>
         <div class="table">
            <table class="table table-striped table-bordered text-center">
            <thead>
                <tr class="bg-info">
                 <th>#</th>
                 {{-- <th>FECHA DE CREACION</th> --}}
                 <!-- <th>MONTO INICIAL</th> -->
                 <th>CUOTA</th>
                 <th>MONTO PAGADO</th>
                 <th colspan="1">ACCIONES</th>
                </tr>
            </thead>
          <tbody>
        <?php 
         $acum = 0;
         $total = 0; 
        ?>
            @foreach($payments as $payment)  
                <tr>
                  <td 
                   @if($payment->receivable->recStatusCode == App\Receivable::STATELESS)
                     style="background-color: #3c8ddc;color:white" 
                   @elseif($payment->receivable->recStatusCode == App\Receivable::PROCESS)
                     style="background-color: #cbb956;color:white" 
                   @elseif($payment->receivable->recStatusCode == App\Receivable::DECLINED) 
                     style="background-color: #78341a;color:white" 
                   @elseif($payment->receivable->recStatusCode == App\Receivable::SUCCESS)
                     style="background-color: #2ab25b;color:white" 
                   @endif >{{ $acum = $acum +1 }}
                </td>
                 <td>{{$payment->receivable->amountDue}}</td>
                 <td>{{$payment->receivable->amountPaid}}</td>
                 <td>
              @if($payment->receivable->paymentInvoiceId == $currentShare)

                 @if($payment->receivable->recStatusCode == App\Receivable::STATELESS || $payment->receivable->recStatusCode == App\Receivable::DECLINED) 
                     @if($invoice[0]->contract->contractStatus == App\Contract::VACANT || $invoice[0]->contract->contractStatus == App\Contract::STARTED)
                  <form-modal-charge r-id="{{$payment->receivable->receivableId}}" country-id="{{$payment->receivable->countryId}}"></form-modal-charge>
                    @endif
                 @endif 

                 @if($payment->receivable->recStatusCode == App\Receivable::PROCESS) 
                   @if($invoice[0]->contract->contractStatus == App\Contract::VACANT || $invoice[0]->contract->contractStatus == App\Contract::STARTED) 
                  <confirm-payment r-id="{{$payment->receivable->receivableId}}" country-id="{{$payment->receivable->countryId}}"></confirm-payment>
                    @endif
                 @endif  

              @endif

                 @if($payment->receivable->recStatusCode == App\Receivable::STATELESS)
                   @if($invoice[0]->contract->contractStatus == App\Contract::VACANT || $invoice[0]->contract->contractStatus == App\Contract::STARTED)
                  <a href="{{route('invoices.paymentsRemove', [
                  'id' => $payment->paymentInvoiceId,
                  'invoiceId' =>$invoice[0]->invoiceId]) }}" class="btn btn-danger btn-sm">
                            <span class="fa fa-times-circle" aria-hidden="true"></span>  {{__('delete')}}
                  </a>
                   @endif
                 @endif

                 @if($payment->receivable->recStatusCode != App\Receivable::STATELESS)  
                 <a href="{{route('receivables.printReceipt', [
                  'receivableId' => $payment->receivable->receivableId]) }}" class="btn btn-info btn-sm">
                            <span class="fa fa-file-invoice" aria-hidden="true"></span>  Recibo
                  </a>
                 @endif 

                 </td>
                </tr>
               @php  
                 $total = $total + $payment->receivable->amountDue; 
                 $total = number_format((float)$total, 2, '.', '');
                @endphp 
              @endforeach
                  <tr>
                    <td></td>
                    <td><h4 class="text-info" align="center" >Suma de Cuotas: {{$total}} </h3></td>
                    <td><h4 class="text-danger" align="center" >Restante a Pagar: {{$invoiceBalance}}</h4></td>
                    <td></td>
                 </tr>
        </tbody>
      </table>
     </div>


           <div class="text-center col-xs-12">
              <a href="{{route('reports.statement', ['id' => $invoice[0]->invoiceId])}}" class="btn btn-primary" data-toggle="tooltip" data-placement="top">  <span class="fa fa-file-pdf" aria-hidden="true"></span> Estado de cuenta
              </a>
                 <a href="{{route('reports.invoice', ['id' => $invoice[0]->invoiceId])}}" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Imprimir">
                     <span class="fa fa-file-pdf" aria-hidden="true"></span> 
                     Factura
                </a>
               @if($btnReturn == 'mod_cont')
                  <a href="{{route('invoices.index',['id' => $invoice[0]->contract->contractId])}}" class="btn btn-warning">
                                 <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
                      </a>
               @elseif($btnReturn == 'mod_adm')
                  <a href="{{route('invoices.all')}}" class="btn btn-warning">
                                 <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
                      </a>
               @endif
            </div>

       </div>
    </div>
  </div>


@endsection
