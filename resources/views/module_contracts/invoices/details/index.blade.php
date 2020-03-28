@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-xs-12 ">
<h3><b>FACTURAS</b></h3>
<h4><b>Contrato:</b> {{$contract[0]->contractNumber}}</h4>
<h4><b>Direccion:</b> {{$contract[0]->siteAddress}}</h4>
<h4><b>Cliente:</b> {{$contract[0]->client->clientName}}</h4>
<h4><b>Descripcion del Proyecto:</b> {{$contract[0]->projectDescription->projectDescriptionName}}</h4>
<h4><b>Uso del Proyecto:</b> {{$contract[0]->projectUse->projectUseName}}</h4>

              <invoice-details invoice-id="{{$invoice[0]->invoiceId}}"></invoice-details>
          

        </div>
      </div>

@endsection
