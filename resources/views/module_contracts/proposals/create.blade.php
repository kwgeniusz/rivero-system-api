@extends('layouts.master')

@section('content')
<div class="col-xs-12 col-lg-8 col-lg-offset-2">
<div class="panel panel-success">
    <div class="panel-heading text-center"> <h3><b>Nueva Propuesta: N° {{$propId}}</b></h3></div>
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
        <form class="form form-prevent-multiple-submits" action="{{Route('proposals.store')}}" method="POST">
        {{csrf_field()}}
@if($modelRs[0]->getTable() == 'pre_contract')
      <input type="hidden" name="modelId" value="{{$modelRs[0]->precontractId}}">
@else
      <input type="hidden" name="modelId" value="{{$modelRs[0]->contractId}}">
@endif
      <input type="hidden" name="modelType" value="{{$modelRs[0]->getTable()}}">

              <div class="form-group">
                <label for="clientName">CLIENTE:</label>
                <input type="text" class="form-control" id="clientName" name="clientName" value="{{ $modelRs[0]->client->clientName}}" disabled="on">
              </div>

              <div class="form-group">
                <label for="contractSiteAddress">DIRECCIÓN:</label>
                <input type="text" class="form-control" id="contractSiteAddress" name="contractSiteAddress" value="{{ $modelRs[0]->siteAddress}}" disabled="on">
              </div>

         <div class="form-group">
            <label for="projectDescriptionId">DESCRIPCION DEL PROYECTO</label>
            <select  class="form-control" name="projectDescriptionId" id="projectDescriptionId" required="on">
             @foreach($projectDescriptions as $item)
                      <option value="{{$item->projectDescriptionId}}" >{{$item->projectDescriptionName}}</option>
                @endforeach</option>
            </select>
          </div> 
 
            <div class="form-group">
            <label for="paymentConditionId">CONDICION DE PAGO</label>
            <select class="form-control" name="paymentConditionId" id="paymentConditionId">
                @foreach($paymentConditions as $paymentC)
                      <option value="{{$paymentC->pCondCode}}" >{{$paymentC->pCondName}}</option>
                @endforeach
            </select>
          </div>

        <div class="row">
          <div class="form-group col-xs-12 col-lg-6">
              <label for="preinvoiceDate">FECHA DE LA PROPUESTA:</label>
              <input class="form-control flatpickr" id="invoiceDate" name="invoiceDate" required> 
            </div>

        <div class="form-group col-xs-12 col-lg-6">
            <label for="invoiceTaxPercent">IMPUESTO (%)</label>
            <input type="number" min="0.00" step="0.01" class="form-control" id="invoiceTaxPercent" name="invoiceTaxPercent" value="{{ $invoiceTaxPercent}}" required>
        </div>
        </div>
      

            <div class="text-center">
              <button type="submit" class="btn btn-primary  button-prevent-multiple-submits">
                <span class="fa fa-check" aria-hidden="true"></span>  {{__('save')}}
              </button>
               <a href="{{URL::previous()}}" class="btn btn-warning">
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
