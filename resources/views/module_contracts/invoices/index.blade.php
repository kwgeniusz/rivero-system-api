@extends('layouts.master')

@section('content')
<h3><b>FACTURAS</b></h3>
<h4><b>Contrato:</b>{{$contract[0]->contractNumber}}</h4>
<h4><b>Direccion:</b> {{$contract[0]->siteAddress}}</h4>
<h4><b>Cliente:</b> {{$contract[0]->client->clientName}}</h4>

    <div class="row">
        <div class="col-xs-12 ">
          <div class="text-center">
     @if($contract[0]->contractStatus <> App\Contract::FINISHED && $contract[0]->contractStatus <> App\Contract::CANCELLED)

        @can('BEF')
            <a href="{{route('invoices.create', ['id' => $contract[0]->contractId])}}" class="btn btn-success text-center" >
                <span class="fa fa-plus" aria-hidden="true"></span>
                   {{__('add')}} Factura
            </a>
        @endcan 
        @can('BCA')     
           <a href="{{route('proposals.create', ['type' => 'contract','id' => $contract[0]->contractId])}}" class="btn btn-primary text-center" >
                <span class="fa fa-plus" aria-hidden="true"></span>
                   {{__('add')}} Propuesta
            </a>
        @endcan     
      @endif
     <br> <br>
    
         <div class="table-responsive">
            <table class="table table-striped table-bordered text-center">
            <thead>
                <tr>
                 <th>#</th>
                 <th>TIPO</th>
                 <th>CONDICION DE PAGO</th> 
                 <th>FECHA</th>
                 <th>DESCRIPCION DEL PROYECTO</th>
                 <th>TOTAL</th>
                 <th>BALANCE</th>
                 <th>CUOTAS</th>
                 <th>{{__('STATUS')}}</th> 
                 <th>{{__('actions')}}</th> 
                 </th>
                </tr>
            </thead>
                <tbody>
        {{-- IMPRESION DE INVOICES --}}

                @foreach($invoices as $invoice)
                <tr>
                   <td>{{$invoice->invId}}</td> 
                   <td>FACTURA</td> 
                   <td>{{$invoice->paymentCondition->pCondName}}</td>
                   <td>{{$invoice->invoiceDate}}</td>
                   <td>{{$invoice->projectDescription->projectDescriptionName}}</td>
                   <td>{{$invoice->netTotal}}</td>
                   <td>{{$invoice->balanceTotal}}</td>
                   <td>{{$invoice->shareSucceed->count()}}/{{$invoice->pQuantity}}</td>  
                   <td
                  @if($invoice->invStatusCode == App\Invoice::OPEN )
                      style="background-color: #2ab25b;color:white"  
                  @elseif($invoice->invStatusCode == App\Invoice::CLOSED )
                       style="background-color: #3c8ddc;color:white" 
                  @elseif($invoice->invStatusCode == App\Invoice::PAID )
                        style="background-color: #78341a;color:white" 
                  @endif
                   >{{$invoice->invoiceStatus[0]->invStatusName}}</td> 
                   <td>
                @if($invoice->netTotal > 0) 
                 @can('BEE')
                  <a href="{{route('invoices.payments', ['btnReturn'=> 'mod_cont','id' => $invoice->invoiceId])}}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Cuotas">
                        <span class="fa fa-dollar-sign" aria-hidden="true"></span> 
                    </a> 
                 @endcan
                 @can('BED')    
                    <a href="{{route('invoices.subcontractors', ['id' => $invoice->invoiceId])}}" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Subcontratistas">
                        <span class="fa fa-user" aria-hidden="true"></span> 
                    </a> 
                    @endcan    
                  @endif  
                  @can('BEB')       
                <a href="{{route('reports.invoice', ['id' => $invoice->invoiceId])}}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Ver">
                     <span class="fa fa-file-pdf" aria-hidden="true"></span> 
                    </a>
                 @endcan
          @if($invoice->invStatusCode == App\Invoice::OPEN )
            @if($contract[0]->contractStatus <> App\Contract::FINISHED && $contract[0]->contractStatus <> App\Contract::CANCELLED)
                 @can('BEC')    
                  <a href="{{route('invoicesDetails.index', ['btnReturn'=> 'mod_cont','id' => $invoice->invoiceId])}}" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Renglones">
                        <span class="fa fa-book" aria-hidden="true"></span> 
                    </a>
                  @endcan
                 @can('BEA') 
                  <a href="{{route('invoices.edit', ['id' => $invoice->invoiceId])}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="{{__('edit')}}">
                        <span class="fa fa-edit" aria-hidden="true"></span> 
                    </a>  
                  @endcan  

                  <invoice-btn-cancel invoice-id="{{$invoice->invoiceId}}" inv-id="{{$invoice->invId}}"></invoice-btn-cancel>
              @endif  
          @endif 

               @if($invoice->invStatusCode == App\Invoice::CLOSED or $invoice->invStatusCode == App\Invoice::PAID )
                 <a href="{{route('invoiceSaleNotes.getAll', ['id' => $invoice->invoiceId])}}" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Notas de Venta">
                     <span class="fa fa-briefcase" aria-hidden="true"></span> 
                </a>
                @endif

            {{--       <a href="{{route('invoices.show', ['id' => $invoice->invoiceId])}}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Anular">
                        <span class="fa fa-times-circle" aria-hidden="true"></span> 
                    </a> --}}
                   
                   </td>
                </tr>
                @endforeach
        {{-- IMPRESION DE PROPUESTAS --}}
                @foreach($proposals as $proposal)
                  <tr>
                   <td>{{$proposal->propId}}</td> 
                   <td>PROPUESTA</td> 
                   <td>{{$proposal->paymentCondition->pCondName}}</td>
                   <td>{{$proposal->proposalDate}}</td>
                   <td>{{$proposal->projectDescription->projectDescriptionName}}</td>
                   <td>{{$proposal->netTotal}}</td>
                   <td>N/A</td>
                   <td>{{$proposal->pQuantity}}</td>  
                   <td>
                    @if($proposal->invoiceId == null)
                      ABIERTA
                    @else
                      CONV. A FACTURA #{{$proposal->invoice->invId}}
                    @endif
                   </td> 
                   <td>


          @if($proposal->invoiceId == null )
                @if($proposal->pQuantity > 0)    
                @can('BCF')     
                  <a href="{{route('proposals.convert', ['id' => $proposal->proposalId])}}" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Convertir en Factura">
                     <span class="fa fa-sync" aria-hidden="true"></span>  
                  </a>
                  @endcan         
                @endif  
                @if($proposal->netTotal > 0) 
                 @can('BCE')      
                  <a href="{{route('proposals.payments', ['btnReturn' => 'mod_adm','id' => $proposal->proposalId])}}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Cuotas">
                        <span class="fa fa-dollar-sign" aria-hidden="true"></span> 
                    </a> 
                    @endcan
                  @endif  
                @if($contract[0]->contractStatus <> App\Contract::FINISHED && $contract[0]->contractStatus <> App\Contract::CANCELLED)     
                @can('BCF')        
                  <a href="{{route('proposalsDetails.index', ['btnReturn' => 'mod_adm','id' => $proposal->proposalId])}}" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Renglones">
                        <span class="fa fa-book" aria-hidden="true"></span> 
                    </a>
                  @endcan
                @can('BCB')       
                  <a href="{{route('proposals.edit', ['id' => $proposal->proposalId])}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="{{__('edit')}}">
                        <span class="fa fa-edit" aria-hidden="true"></span> 
                    </a> 
                  @endcan   
                @endif             
            @endif 
             @can('BCC')  
                <a href="{{route('reports.proposal', ['id' => $proposal->proposalId])}}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Ver">
                     <span class="fa fa-file-pdf" aria-hidden="true"></span> 
                    </a>
              @endcan
          {{--  <a href="{{route('proposals.show', ['id' => $proposal->proposalId])}}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Anular">
                        <span class="fa fa-times-circle" aria-hidden="true"></span> 
                    </a> --}}
                   
                   </td>
                </tr>
                @endforeach
                </tbody>
            </table>
                {{-- {{$invoices->render()}} --}}
        </div>

@if($contract[0]->contractStatus <> App\Contract::FINISHED && $contract[0]->contractStatus <> App\Contract::CANCELLED)
             <a href="{{Route('contracts.index')}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
              </a>
 @elseif($contract[0]->contractStatus == App\Contract::FINISHED)
             <a href="{{Route('contracts.finished')}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
              </a>
 @elseif($contract[0]->contractStatus == App\Contract::CANCELLED)
             <a href="{{Route('contracts.cancelled')}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
              </a>
 @endif     
        </div>
        </div>
    </div>



@endsection
