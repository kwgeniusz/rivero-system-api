@extends('layouts.master')

@section('content')
<h3><b>Facturas</b></h3>
<h4><b>Contrato:</b> N° {{$contract[0]->contractNumber}}</h4>
<h4><b>Cliente:</b> {{$contract[0]->client->clientName}}</h4>
    <div class="row">
        <div class="col-xs-12 ">
          <div class="text-center">


            <a href="{{route('invoices.create', ['id' => $contract[0]->contractId])}}" class="btn btn-success text-center" >
                <span class="fa fa-plus" aria-hidden="true"></span>
                   {{__('add')}} Factura
            </a>

     <br> <br>
    
         <div class="table-responsive">
            <table class="table table-striped table-bordered text-center">
            <thead>
                <tr>
                 <th>N° FACTURA</th> 
                 <th>FECHA</th>
                 <th>SUB-TOTAL</th>
                 <th>IMPUESTO</th>
                 <th>TOTAL</th>
                 <th>{{__('STATUS')}}</th> 
                 <th>{{__('actions')}}</th> 
                 </th>
                </tr>
            </thead>
                <tbody>
                @foreach($invoices as $invoice)
                <tr>
                   <td>{{$invoice->invoiceNumber}}</td> 
                   <td>{{$invoice->invoiceDate}}</td>
                   <td>{{$invoice->grossTotal}}</td>
                   <td>{{$invoice->taxAmount}}</td> 
                   <td>{{$invoice->netTotal}}</td> 
                   <td>{{$invoice->status}}</td> 
                   <td>
                 @if($invoice->status == 'ABIERTO')
                  <a href="{{route('invoicesDetails.index', ['id' => $invoice->invoiceId])}}" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Renglones">
                        <span class="fa fa-book" aria-hidden="true"></span> 
                    </a>
                  @elseif($invoice->status == 'CERRADO')
                   <a href="{{route('invoices.payments', ['id' => $invoice->invoiceId])}}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Cuotas">
                        <span class="fa fa-dollar-sign" aria-hidden="true"></span> 
                    </a>
                    |
                      <a href="{{route('reports.invoice', ['id' => $invoice->invoiceId])}}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Imprimir">
                     <span class="fa fa-file-pdf" aria-hidden="true"></span> 
                    </a>
                  @endif  
                {{--    |
                  <a href="{{route('invoices.edit', ['id' => $invoice->invoiceId])}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="{{__('edit')}}">
                        <span class="fa fa-edit" aria-hidden="true"></span> 
                    </a> --}}
          {{--           <a href="{{route('invoices.show', ['id' => $invoice->invoiceId])}}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="{{__('delete')}}">
                        <span class="fa fa-times-circle" aria-hidden="true"></span> 
                    </a> --}}
                   
                   </td>
                </tr>
                @endforeach
                </tbody>
            </table>
                {{-- {{$invoices->render()}} --}}
        </div>
  
             <a href="{{Route('contracts.index')}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
              </a>
        </div>
        </div>
    </div>



@endsection
