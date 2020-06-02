@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-xs-12">
<h3><b>FACTURA > SUBCONTRATISTAS</b></h3>
  {{-- @if($btnReturn == 'mod_cont') --}}
<div class="text-center">
   {{-- <a href="{{route('invoices.index',['id' => $invoice[0]->contractId])}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
       </a> --}}
   <a href=" {{URL::previous()}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
       </a>

</div>
<br>
{{--   @elseif($btnReturn == 'mod_adm')
   <a href="{{route('invoices.all')}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
       </a>
  @endif --}}
{{-- <h4><b>Contrato:</b> {{$invoice[0]->invoiceNumber}}</h4>
<h4><b>Direccion:</b> {{$invoice[0]->siteAddress}}</h4>
<h4><b>Cliente:</b> {{$invoice[0]->client->clientName}}</h4>
<h4><b>Descripcion del Proyecto:</b> {{$invoice[0]->projectDescription->projectDescriptionName}}</h4>
<h4><b>Uso del Proyecto:</b> {{$invoice[0]->projectUse->projectUseName}}</h4>
 --}}
              <invoice-subcontractors invoice-id="{{$invoice[0]->invoiceId}}"></invoice-subcontractors>
          

        </div>
      </div>

@endsection
