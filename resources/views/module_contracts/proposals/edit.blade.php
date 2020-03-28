@extends('layouts.master')

@section('content')
<div class="col-xs-12 col-xs-offset-1">
<div class="panel panel-success col-xs-7">
    <div class="panel-heading"> <h3><b>Editar Propuesta: N° {{$proposal[0]->propId}}</b></h3></div>
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
  <form class="form" action="{{Route('proposals.update',['id' => $proposal[0]->proposalId])}}" method="POST">
        {{csrf_field()}}
        {{method_field('PUT')}}
      <input type="hidden" name="precontractId" value="{{$proposal[0]->precontractId}}">


              <div class="form-group">
                <label for="clientName">CLIENTE:</label>
                <input type="text" class="form-control" id="clientName" name="clientName" value="{{ $proposal[0]->client->clientName}}" disabled="on">
              </div>

              <div class="form-group">
                <label for="address">DIRECCIÓN:</label>
                <input type="text" class="form-control" id="address" name="address" value="{{ $proposal[0]->precontract->siteAddress}}" disabled="on">
              </div>

            <div class="form-group">
            <label for="paymentConditionId">CONDICION DE PAGO</label>
            <select class="form-control" name="paymentConditionId" id="paymentConditionId">
             @foreach($paymentConditions as $paymentC)
                   @if ($paymentC->pCondCode == $proposal[0]->pCondId)
                      <option value="{{$paymentC->pCondCode}}" selected>{{$paymentC->pCondName}}</option>
                  @else
                      <option value="{{$paymentC->pCondCode}}" >{{$paymentC->pCondName}}</option>
               @endif
                @endforeach 
            </select>
          </div>

        <div class="row">
          <div class="form-group col-xs-5">
              <label for="preinvoiceDate">FECHA DE LA FACTURA:</label>
              <input class="form-control flatpickr" id="invoiceDate" name="invoiceDate" value="{{ $proposal[0]->proposalDate}}" required> 
            </div>

        <div class="form-group col-xs-4">
            <label for="invoiceTaxPercent">IMPUESTO (%)</label>
            <input type="number" min="0.00" step="0.01" class="form-control" id="invoiceTaxPercent" name="invoiceTaxPercent" value="{{ $proposal[0]->taxPercent}}" required>
        </div>
        </div>

            <div class="text-center">
              <button type="submit" class="btn btn-primary">
                <span class="fa fa-check" aria-hidden="true"></span>  {{__('save')}}
              </button>
              <a href="{{route('proposals.index', ['id' => $proposal[0]->precontractId])}}" class="btn btn-warning">
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
