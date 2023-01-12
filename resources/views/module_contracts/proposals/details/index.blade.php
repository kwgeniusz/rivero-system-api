@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-xs-12 ">
<h3><b>PROPUESTAS</b></h3>
     @if($btnReturn == 'mod_cont')
                  @if($proposal[0]->contractId ==null)   
                   <a href="{{route('precontractsProposals.index', ['id' => $proposal[0]->precontractId])}}" class="btn btn-warning">
                     <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
                   </a>
                  @else
                  <a href="{{route('invoices.index', ['id' => $proposal[0]->contractId])}}" class="btn btn-warning">
                     <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
                  </a>
                  @endif
      @elseif($btnReturn == 'mod_adm')
                  <a href="{{route('proposals.all')}}" class="btn btn-warning">
                                 <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
                      </a>
      @endif
@if($modelRs[0]->getTable() == 'pre_contract')
<h4><b>Precontrato:</b> {{$modelRs[0]->preId}}</h4>
@else
<h4><b>Contrato:</b> {{$modelRs[0]->contractNumber}}</h4>
@endif
<h4><b>Direccion:</b> {{$modelRs[0]->siteAddress}}</h4>
<h4><b>Cliente:</b> {{$modelRs[0]->client->clientName}}</h4>
<h4><b>Descripcion del Proyecto:</b> {{$proposal[0]->projectDescription->projectDescriptionName}}</h4>
<h4><b>Uso del Proyecto:</b> {{$modelRs[0]->projectUse->projectUseName}}</h4>

              <proposal-details proposal-id="{{$proposal[0]->proposalId}}"></proposal-details>
          
        </div>
      </div>

@endsection
