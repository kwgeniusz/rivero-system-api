@extends('layouts.master')

@section('content')

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
                    <td>{{$invoice[0]->invoiceNumber}} </td>
                    <td>{{$invoice[0]->contract->contractNumber}} </td>
                    <td>{{$invoice[0]->client->clientName}} </td>
                    <td>{{$invoice[0]->address}} </td>
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
<br>
  <div class="col-xs-offset-3 col-xs-5 ">
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

    <div class="row ">
     <div class="col-xs-12">
     <div class="text-center">
      <form class="form-inline" action="{{Route('invoices.paymentsAdd')}}" method="POST">
      {{csrf_field()}}
         <div class="form-group">
            <label for="amount" >MONTO</label>
              <input style=" width:60%" type="number" min='0.01' step="0.01" class="form-control" id="amount" name="amount" required autocomplete="off">
         </div>
          <div class="form-group ">
                <label for="paymentDate">FECHA</label>
                <input style="width:50%" class="form-control flatpickr" id="paymentDate" name="paymentDate" required autocomplete="off">
              </div>
           <input type="hidden" name="invoiceId" value="{{$invoice[0]->invoiceId}}">
           <button type="submit" class="btn btn-success">
                 <span class="fa fa-plus" aria-hidden="true"></span>
                 Agregar Cuota
            </button>
        </form>
   </div>
    </div>
    </div>


        <br>
         <div class="table-responsive">
            <table class="table table-striped table-bordered text-center ">
            <thead>
                <tr class="bg-info">
                 <th>ESTADO</th>
                 <th>N°</th>
                 <th>FECHA</th>
                 <th>MONTO INICIAL</th>
                 <th>MONTO A PAGAR</th>
                 <th>MONTO PAGADO</th>
                 <th colspan="2">ACCIONES</th>
                </tr>
            </thead>
          <tbody>
        <?php 
         $acum = 0;
         $total = 0; 
        ?>
            @foreach($payments as $payment)

                <tr>
                 @if($payment->receivable->status == '1')
                   <td class="bg-info"></td>
                 @elseif($payment->receivable->status == '2')
                   <td class="bg-warning"></td>
                 @elseif($payment->receivable->status == '3')
                  <td class="bg-danger"></td>
                 @elseif($payment->receivable->status == '4')
                   <td class="bg-success"></td>
                 @endif
                 <td>{{ $acum = $acum +1 }}</td>
                 <td>{{$payment->paymentDate}}</td>
                 <td>{{$payment->amount}}</td>
                 <td>{{$payment->receivable->amountDue}}</td>
                 <td>{{$payment->receivable->amountPaid}}</td>
                 <td>
              @if($payment->receivable->paymentInvoiceId == $currentShare)
                 @if($payment->receivable->status == '1' || $payment->receivable->status == '3')  
                  <form-modal-charge r-id="{{$payment->receivable->receivableId}}" country-id="{{$payment->receivable->countryId}}"></form-modal-charge>
                 @endif 
                 @if($payment->receivable->status == '2')  
                <confirm-payment r-id="{{$payment->receivable->receivableId}}" country-id="{{$payment->receivable->countryId}}"></confirm-payment>
                 @endif  
              @endif

                 @if($payment->receivable->status == '1')
                  <a href="{{route('invoices.paymentsRemove', [
                  'id' => $payment->paymentInvoiceId,
                  'invoiceId' =>$invoice[0]->invoiceId]) }}" class="btn btn-danger btn-sm">
                            <span class="fa fa-times-circle" aria-hidden="true"></span>  {{__('delete')}}
                  </a>
                 @endif
                 @if($payment->receivable->status != '1')  
                 <a href="{{route('receivables.printReceipt', [
                  'receivableId' => $payment->receivable->receivableId]) }}" class="btn btn-info btn-sm">
                            <span class="fa fa-file-invoice" aria-hidden="true"></span>  Recibo
                  </a>
                 @endif  
                 </td>
                </tr>
               @php  
               $total = $total + $payment->amount; 
               $total = number_format((float)$total, 2, '.', '');

                @endphp 
              @endforeach
        </tbody>
      </table>
MONTO QUE RESTA POR PAGAR:{{$invoiceBalance}}

                 <h3 class="text-success" align="center" >Monto Total: {{$total}}  </h3>
     </div>


           <div class="text-center">
             <a href="{{route('invoices.index', ['id' => $invoice[0]->contractId])}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
              </a>
            </div>

       </div>
    </div>
  </div>


@endsection
