@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-xs-12 ">
<h3><b>PROPUESTAS</b></h3>
<h4><b>Precontrato:</b> {{$precontract[0]->preId}}</h4>
<h4><b>Direccion:</b> {{$precontract[0]->siteAddress}}</h4>
<h4><b>Cliente:</b> {{$precontract[0]->client->clientName}}</h4>
<h4><b>Descripcion del Proyecto:</b> {{$precontract[0]->projectDescription->projectDescriptionName}}</h4>
<h4><b>Uso del Proyecto:</b> {{$precontract[0]->projectUse->projectUseName}}</h4>

              <proposal-details proposal-id="{{$proposal[0]->proposalId}}"></proposal-details>
          

        </div>
      </div>

@endsection
