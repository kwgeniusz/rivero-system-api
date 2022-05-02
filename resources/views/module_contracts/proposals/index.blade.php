@extends('layouts.master')

@section('content')
<h3><b>PROPUESTAS</b></h3>
<h4><b>Precontrato:</b> {{$precontract[0]->preId}}</h4>
<h4><b>Direccion:</b> {{$precontract[0]->siteAddress}}</h4>
<h4><b>Cliente:</b> {{$precontract[0]->client->clientName}}</h4>

    <div class="row">
        <div class="col-xs-12 ">
          <div class="text-center">

@if($precontract[0]->contractId == null)
        @can('BCA')
            <a href="{{route('proposals.create', ['modelType' => 'pre_contract','id' => $precontract[0]->precontractId])}}" class="btn btn-success text-center" >
                <span class="fa fa-plus" aria-hidden="true"></span>
                   {{__('add')}} Propuesta
            </a>
        @endcan
@endif
        <a href="{{Route('precontracts.index')}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
        </a>
     <br> <br>
    
         <div class="table-responsive">
            <table class="table table-striped table-bordered text-center">
            <thead>
                <tr>
                 <th>N° PROPUESTA</th> 
                 <th>CONDICION DE PAGO</th>
                 <th>FECHA</th>
                 <th>DESCRIPCION DEL PROYECTO</th>
                 <th>SUB-TOTAL</th>
                 <th>IMPUESTO</th>
                 <th>TOTAL</th>
                 <th>CUOTAS</th>
                 <th>REGISTRADO POR</th>
                 </th>
                </tr>
            </thead>
                <tbody>
                @foreach($proposals as $proposal)
                <tr>
                   <td>
                    <div class="dropdown">
                    @if($proposal->invoice != null)
                      <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    @else
                      <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    @endif
                        <span class="caret"></span> {{$proposal->propId}}
                      </button>
                      <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li class="dropdown-header">Acciones</li>
                        
                     @if($precontract[0]->contractId == null)  
                        @can('BCB')    
                          <li><a href="{{route('proposals.edit', ['id' => $proposal->proposalId])}}"><span class="fa fa-edit" aria-hidden="true"></span>Editar Propuesta</a></li>
                        @endcan
                        @can('BCD')
                          <li><a href="{{route('proposalsDetails.index', ['btnReturn' => 'mod_cont','modelType' => 'pre_contract','id' => $proposal->proposalId])}}"><span class="fa fa-book" aria-hidden="true"></span>Renglones</a></li>
                        @endcan
                        @if($proposal->netTotal > 0)    
                         @can('BCE')
                            <li><a href="{{route('proposals.payments', ['btnReturn' => 'mod_cont','id' => $proposal->proposalId])}}"><span class="fa fa-dollar-sign" aria-hidden="true"></span> Cuotas</a></li>          
                         @endcan
                        @endif  
                    @endif  
                        @can('BCC')      
                          <li><a href="{{route('reports.proposal', ['id' => $proposal->proposalId])}}"><span class="fa fa-file-pdf" aria-hidden="true"></span> Imprimir</a></li>
                        @endif  
                        @if($proposal->pQuantity > 0)  
                          @can('BCF') 
                                 <li role="separator" class="divider"></li>
                                 <li><a href="{{route('proposal.duplicate', ['id' => $proposal->proposalId])}}"><span class="fa fa-copy" aria-hidden="true"></span>Duplicar Propuesta</a></li>
                              @if($precontract[0]->contractId == null)  
                                 <li role="separator" class="divider"></li>
                                 <li><a href="{{route('precontracts.convert', ['id' => $proposal->proposalId])}}"><span class="fa fa-sync" aria-hidden="true"></span> Convertir en Factura</a></li>
                              @endcan    
                           @endcan    
                       @endif        
                      </ul>
                    </div>
                  </td> 
                   <td>{{$proposal->paymentCondition->pCondName}}</td>
                   <td>{{$proposal->proposalDate}}</td>
                   <td>{{$proposal->projectDescription->projectDescriptionName}}</td>
                   <td>{{$proposal->grossTotal}}</td>
                   <td>{{$proposal->taxAmount}}</td> 
                   <td>{{$proposal->netTotal}}</td> 
                   <td>{{$proposal->pQuantity}}</td> 
                   <td>{{$proposal->user->fullName}}</td> 
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
  
         
        </div>
        </div>
    </div>



@endsection
