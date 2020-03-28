@extends('layouts.master')

@section('content')
<div class="col-xs-12 col-xs-offset-1">
<div class="panel panel-success col-xs-7">
    <div class="panel-heading"> <h3><b>Editar Factura: N° {{$invoice[0]->invId}}</b></h3></div>
    <div class="panel-body">

      <div class="row ">
          <div class="col-xs-12 ">
        @if ($errors->any())
          <div class="alert alert-danger">
              <h4>Errores:</h4>
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif
  <form class="form" action="{{Route('invoices.update',['id' => $invoice[0]->invoiceId])}}" method="POST">
        {{csrf_field()}}
        {{method_field('PUT')}}
      <input type="hidden" name="contractId" value="{{$invoice[0]->contractId}}">
      
       <div class="row">
          <div class="form-group col-xs-4">
            <label for="controlNumber">CONTRATO:</label>
            <input type="text" class="form-control" id="controlNumber" name="controlNumber" value="{{ $invoice[0]->contract->contractNumber}}" disabled="on">
          </div>
        </div>

              <div class="form-group">
                <label for="clientName">CLIENTE:</label>
                <input type="text" class="form-control" id="clientName" name="clientName" value="{{ $invoice[0]->client->clientName}}" disabled="on">
              </div>

              <div class="form-group">
                <label for="address">DIRECCIÓN:</label>
                <input type="text" class="form-control" id="address" name="address" value="{{ $invoice[0]->contract->siteAddress}}" disabled="on">
              </div>

            <div class="form-group">
            <label for="paymentConditionId">CONDICION DE PAGO</label>
            <select class="form-control" name="paymentConditionId" id="paymentConditionId">
             @foreach($paymentConditions as $paymentC)
                   @if ($paymentC->pCondCode == $invoice[0]->pCondId)
                      <option value="{{$paymentC->pCondCode}}" selected>{{$paymentC->pCondName}}</option>
                  @else
                      <option value="{{$paymentC->pCondCode}}" >{{$paymentC->pCondName}}</option>
               @endif
                @endforeach 
            </select>
          </div>

        <div class="row">
          <div class="form-group col-xs-5">
              <label for="invoiceDate">FECHA DE LA FACTURA:</label>
              <input class="form-control flatpickr" id="invoiceDate" name="invoiceDate" value="{{ $invoice[0]->invoiceDate}}" required> 
            </div>

        <div class="form-group col-xs-4">
            <label for="taxPercent">IMPUESTO (%)</label>
            <input type="number" min="0.00" step="0.01" class="form-control" id="taxPercent" name="taxPercent" value="{{ $invoice[0]->taxPercent}}" required>
        </div>
        </div>

            <div class="text-center">
              <button type="submit" class="btn btn-primary">
                <span class="fa fa-check" aria-hidden="true"></span>  {{__('save')}}
              </button>
              <a href="{{route('invoices.index', ['id' => $invoice[0]->contractId])}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
              </a>
            </div>
            </form>

          </div>
        </div>

      </div>
    </div>
  </div>
@endsection
