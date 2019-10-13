@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-xs-12 ">
<h3><b>Facturas</b></h3>
<h4><b>Contrato:</b> {{$contract[0]->contractNumber}}</h4>
<h4><b>Cliente:</b> {{$contract[0]->client->clientName}}</h4>

              <invoices-details invoice-id="{{$invoice[0]->invoiceId}}"></invoices-details>
          

        </div>
      </div>

@endsection
