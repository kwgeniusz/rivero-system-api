@extends('layouts.master')

@section('content')
<h3><b>PROPUESTAS</b></h3>
<h4><b>Precontrato:</b> {{$precontract[0]->preId}}</h4>
<h4><b>Cliente:</b> {{$precontract[0]->client->clientName}}</h4>

    <div class="row">
        <div class="col-xs-12 ">
          <div class="text-center">

@if($precontract[0]->contractId == null)
            <a href="{{route('proposals.create', ['id' => $precontract[0]->precontractId])}}" class="btn btn-success text-center" >
                <span class="fa fa-plus" aria-hidden="true"></span>
                   {{__('add')}} Propuesta
            </a>
@endif
     <br> <br>
    
         <div class="table-responsive">
            <table class="table table-striped table-bordered text-center">
            <thead>
                <tr>
                 <th>N° PROPUESTA</th> 
                 <th>CONDICION DE PAGO</th>
                 <th>FECHA</th>
                 <th>SUB-TOTAL</th>
                 <th>IMPUESTO</th>
                 <th>TOTAL</th>
                 <th>CUOTAS</th>
                 <th>{{__('actions')}}</th> 
                 </th>
                </tr>
            </thead>
                <tbody>
                @foreach($proposals as $proposal)
                <tr>

                   <td>
                    {{$proposal->propId}}
                  </td> 
                   <td>{{$proposal->paymentCondition->pCondName}}</td>
                   <td>{{$proposal->proposalDate}}</td>
                   <td>{{$proposal->grossTotal}}</td>
                   <td>{{$proposal->taxAmount}}</td> 
                   <td>{{$proposal->netTotal}}</td> 
                   <td>{{$proposal->pQuantity}}</td> 
                   <td>

@if($precontract[0]->contractId == null)
           @if($proposal->pQuantity > 0)         
             <a href="{{route('precontracts.convert', ['id' => $proposal->proposalId])}}" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Convertir en Factura">
                     <span class="fa fa-sync" aria-hidden="true"></span>  
             </a>         
           @endif  
           @if($proposal->netTotal > 0)         
           <a href="{{route('proposals.payments', ['id' => $proposal->proposalId])}}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Cuotas">
                        <span class="fa fa-dollar-sign" aria-hidden="true"></span> 
            </a> 
           @endif  

            <a href="{{route('proposalsDetails.index', ['id' => $proposal->proposalId])}}" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Renglones">
                        <span class="fa fa-book" aria-hidden="true"></span> 
              </a>
              <a href="{{route('reports.proposal', ['id' => $proposal->proposalId])}}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Imprimir">
                     <span class="fa fa-file-pdf" aria-hidden="true"></span> 
              </a>
              |
           <a href="{{route('proposals.edit', ['id' => $proposal->proposalId])}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="{{__('edit')}}">
                        <span class="fa fa-edit" aria-hidden="true"></span> 
          </a>   
<!--             <a href="{{route('proposals.show', ['id' => $proposal->proposalId])}}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="{{__('delete')}}"><span class="fa fa-times-circle" aria-hidden="true"></span> 
                    </a> -->
 @else
           <a href="{{route('reports.proposal', ['id' => $proposal->proposalId])}}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Imprimir">
                     <span class="fa fa-file-pdf" aria-hidden="true"></span> 
              </a>
                  @if($proposal->invoiceId != null)
                    (CONVERTIDA)
                    @endif
 @endif
                   </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
  
             <a href="{{Route('precontracts.index')}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
              </a>
        </div>
        </div>
    </div>



@endsection
