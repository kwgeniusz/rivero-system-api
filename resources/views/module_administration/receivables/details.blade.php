@extends('layouts.master')

@section('content')


<div class="panel panel-default col-xs-12">
    <div class="panel-body">

<div class="text-center"><h4 class="text-info">DATOS DEL CLIENTE</h4></div>
 <div class="table-responsive">
            <table class="table table-striped table-bordered text-center ">
            <thead>
                <tr class="bg-success">
                 <th>CODIGO</th>
                 <th>NOMBRE</th>
                 <th>DIRECCION</th>
                 <th>TELEFONO</th>
                 <th>CUOTAS</th>
                 <th>DEUDA TOTAL</th>
                 </th>
                </tr>
            </thead>
          <tbody>
                <tr>
                     <td>{{$receivable[0]->client->clientCode}}</td>
                     <td>{{$receivable[0]->client->clientName}}</td>
                     <td>{{$receivable[0]->client->clientAddress}}</td>
                     <td>{{$receivable[0]->client->clientPhone}}</td>
                     <td>{{$receivable[0]->cuotas}}</td>
                     <td>{{$receivable[0]->balanceTotal}}</td>
                </tr>
        </tbody>
      </table>
  </div>

<hr>
<div class="row ">
  <div class="col-xs-12">
    <h4 class="text-info text-center">DETALLES - CUENTAS POR COBRAR</h4>
         <!-- INICIO DE LA TABLA COLLAPSE COMPONENT -->

   @foreach($receivablesInvoices as $index => $receivable)
     @php 
       $acum = 0;
       $totalDue = 0;
     @endphp

     <div class="panel-group col-xs-6" id="accordion" role="tablist" aria-multiselectable="true">
        <div class="panel panel-primary">
         <div class="panel-heading" role="tab" id="headingOne">
           <h4 class="panel-title">
             <div role="button" data-toggle="collapse" data-parent="#accordion" href="#{{$index}}" aria-expanded="true" aria-controls="{{$index}}">
              @foreach($receivable as $share) 
               @php
               $totalDue += $share->amountDue;
               $totalDue = number_format((float)$totalDue, 2, '.', '');
               @endphp 
              @endforeach
              FACTURA N° {{$receivable[0]->invoice->invId}} - MONTO A COBRAR: {{$totalDue}}
            </div>
           </h4>
         </div>
          <div id="{{$index}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
           <div class="panel-body">
           <h4 class="text-info text-center">CUOTAS</h4> 

              <!-- INICIO DE LA TABLA CUOTAS -->
               <div class="table-responsive">
                   <table class="table table-striped table-bordered text-center ">
                   <thead>
                       <tr class="bg-info">
                        <th>N°</th>
                        <th>MONTO</th>
                        <th>ACCIONES</th>
                       </tr>
                   </thead>
                  <tbody>
                   @foreach($receivable as $share)
                       <tr>
                        <td>{{ $acum = $acum +1 }}</td>
                        <td>{{$share->amountDue}}</td>
                        <td>
                        @if($acum == 1) 
                              @if($share->status == '1' || $share->status == '3')  
                               <form-modal-charge r-id="{{$share->receivableId}}" country-id="{{$share->countryId}}"></form-modal-charge>
                              @elseif($share->status == '2')  
                               <confirm-payment r-id="{{$share->receivableId}}" country-id=" {{$share->countryId}}"></confirm-payment>
                              @endif  
{{-- 
                               <a href="{{route('reports.paymentRequest', ['receivableId' => $share->receivableId])}}" class="btn btn-info btn-sm " data-toggle="tooltip" data-placement="top" title="">
                                <span class="fa fa-file-pdf" aria-hidden="true"></span> Solicitud de Cobro
                               </a> --}}
                        @endif
                       </td>
                       </tr>
                    @endforeach
                 </tbody>
                </table>
                <!-- FIN TABLA CUOTAS -->
              <div class="text-center">
                <a href="{{route('reports.invoice', ['id' => $receivable[0]->invoiceId])}}" class="btn btn-danger btn-sm " data-toggle="tooltip" data-placement="top" title="">
                     <span class="fa fa-file-pdf" aria-hidden="true"></span> Ver Factura
                    </a>
              </div>  
            </div>

          </div>
         </div>
        </div>
    </div>
   @endforeach
   <!-- FIN COLLAPSED -->
    </div>
  </div>
            <div class="text-center">
             <a href="{{route('receivables.index')}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
              </a>
           </div>
       </div>
    </div>



@endsection
