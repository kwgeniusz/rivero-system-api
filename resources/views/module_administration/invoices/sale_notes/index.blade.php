@extends('layouts.master')

@section('content')

<div class="panel panel-default col-xs-12">
    <div class="panel-body">

<h4 class="text-center"><b>FACTURA</b></h4>
    <div class="row">
        <div class="col-xs-12 ">
         <div class="table-responsive">

            <table class="table table-striped table-bordered text-center">
            <thead  class="bg-success">
                <tr>
                 <th>N° FACTURA</th>
                 <th>CLIENTE</th>
                 <th>CONTRATO</th>
                 <th>DIRECCION</th> 
                 <th>FECHA</th>
                 <th>DESCRIPCION DEL PROYECTO</th>
                 <th>TOTAL</th>
                 <th>BALANCE</th>
                 <th>CUOTAS</th>
                 <th>{{__('STATUS')}}</th> 
                </tr>
            </thead>
                <tbody>

                <tr>
                   <td>{{$invoice[0]->invId}}</td> 
                    <td>{{$invoice[0]->client->clientName}} </td>
                   <td>{{$invoice[0]->contract->contractNumber}}</td> 
                   <td>{{$invoice[0]->contract->siteAddress}}</td>
                   <td>{{$invoice[0]->invoiceDate}}</td>
                   <td>{{$invoice[0]->projectDescription->projectDescriptionName}}</td>
                   <td>{{$invoice[0]->netTotal}}</td>
                   <td>{{$invoice[0]->balanceTotal}}</td>
                   <td><a href="{{route('invoices.payments', ['btnReturn' => 'mod_adm','id' => $invoice[0]->invoiceId])}}">
                    {{$invoice[0]->shareSucceed->count()}}/{{$invoice[0]->pQuantity}}
                       </a>
                   </td>  
                   <td
                  @if($invoice[0]->invStatusCode == App\Invoice::OPEN )
                      style="background-color: #2ab25b;color:white"  
                  @elseif($invoice[0]->invStatusCode == App\Invoice::CLOSED )
                       style="background-color: #3c8ddc;color:white" 
                  @elseif($invoice[0]->invStatusCode == App\Invoice::PAID )
                        style="background-color: #78341a;color:white" 
                   @elseif($invoice[0]->invStatusCode == App\Invoice::COLLECTION )
                        style="background-color: #cbb956;color:white" 
                  @endif
                   >
                   <a style="color: white;" href="{{route('reports.invoice', ['id' => $invoice[0]->invoiceId])}}">
                     <span class="fa fa-file-pdf" aria-hidden="true"></span> 
                     {{$invoice[0]->invoiceStatus[0]->invStatusName}} 
                    </a></td> 
                </tr>
                </tbody>
            </table>
           </div>
      </div>
   </div>

<h4><b>NOTAS DE VENTA</b></h4>

 <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active "><a class="bg-info" href="#creditNote" aria-controls="creditNote" role="tab" data-toggle="tab">NOTAS DE CREDITO</a></li>

    <li role="presentation"><a class="bg-info" href="#debitNote" aria-controls="debitNote" role="tab" data-toggle="tab">NOTAS DE DEBITO</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="creditNote">
      <br>

     <div class="row">
        <div class="col-xs-12 ">
   @if($invoice[0]->invStatusCode != App\Invoice::PAID)                 
      <center>
           <a href="{{route('invoiceSaleNotes.create',['id'=> $invoice[0]->invoiceId, 'noteType'=> App\SaleNote::CREDIT])}}" class="btn btn-success" >
                <span class="fa fa-plus" aria-hidden="true"></span>
                   {{__('add')}}
            </a>
      </center>
   @endif   
      <br>
         <div class="table-responsive">
            <table class="table table-striped table-bordered text-center">
            <thead  class="bg-success">
                <tr>
                  <td>ID</td>
                  <td>REFERENCIA</td>
                  <td>FECHA</td>
                  <td>CONCEPTO</td>
                  <td>CLIENTE</td>
                  <td>TOTAL</td>
                  <td>ACCIONES</td>
                </tr>
            </thead>
                <tbody>
                @foreach($creditNotes as $item)
                  <tr>
                     <td>{{$item->salId}}</td> 
                     <td>{{$item->reference}}</td>
                     <td>{{$item->dateNote}}</td>
                     <td>{{$item->concept}}</td>   
                     <td>{{$item->client->clientName}}</td>
                     <td>{{$item->netTotal}}</td>   
                     <td>   <a href="{{route('reports.credit-note', ['id' => $item->salNoteId])}}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Ver">
                     <span class="fa fa-file-pdf" aria-hidden="true"></span> 
                    </a></td>   
                  </tr>
                @endforeach
                </tbody>
            </table>
           </div>
      </div>
   </div>
   </div> <!--tab 1 final-->

    <div role="tabpanel" class="tab-pane" id="debitNote">
      <br>
      
     <div class="row">
        <div class="col-xs-12 ">
   @if($invoice[0]->invStatusCode != App\Invoice::PAID)       
      <center>
           <a href="{{route('invoiceSaleNotes.create',['id'=> $invoice[0]->invoiceId, 'noteType'=> App\SaleNote::DEBIT])}}" class="btn btn-success" >
                <span class="fa fa-plus" aria-hidden="true"></span>
                   {{__('add')}}
            </a>
      </center>
   @endif   
      <br>
         <div class="table-responsive">
            <table class="table table-striped table-bordered text-center">
            <thead  class="bg-success">
                <tr>
                  <td>ID</td>
                  <td>REFERENCIA</td>
                  <td>FECHA</td>
                  <td>CONCEPTO</td>
                  <td>CLIENTE</td>
                  <td>TOTAL</td>
                  <td>ACCIONES</td>
                </tr>
            </thead>
                <tbody>
                @foreach($debitNotes as $item)
                  <tr>
                     <td>{{$item->salId}}</td> 
                     <td>{{$item->reference}}</td>
                     <td>{{$item->dateNote}}</td>
                     <td>{{$item->concept}}</td>   
                     <td>{{$item->client->clientName}}</td>
                     <td>{{$item->netTotal}}</td>   
                     <td>   <a href="{{route('reports.debit-note', ['id' => $item->salNoteId])}}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Ver">
                     <span class="fa fa-file-pdf" aria-hidden="true"></span> 
                    </a></td>   
                  </tr>
                @endforeach
                </tbody>
            </table>
           </div>
      </div>
   </div>
   </div>  <!--tab 2 final-->

</div><!--tab container final-->
  <center>
       <a href="{{route('invoices.all')}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
       </a>
  </center>
</div>
</div>

@endsection
