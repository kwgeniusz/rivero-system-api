@extends('layouts.master')

@section('content')
<div class="create">
  <form  class="formulario" action="{{Route('precontracts.store')}}" method="POST">
    <div>
      <h3><i class="fas fa-book"></i> Nueva Propuesta: N° {{$propId}}</h3>
      <div class="boxes">
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
        {{csrf_field()}}
        @if($modelRs[0]->getTable() == 'pre_contract')
        <input type="hidden" name="modelId" value="{{$modelRs[0]->precontractId}}">
        @else
        <input type="hidden" name="modelId" value="{{$modelRs[0]->contractId}}">
        @endif
        <input type="hidden" name="modelType" value="{{$modelRs[0]->getTable()}}">
        <div class="inputother boxes2">
          <label for="clientName"><i class="fas fa-user-tie"></i> CLIENTE:</label>
          <input type="text" style="cursor: no-drop" class="input-label" id="clientName" name="clientName" value="{{ $modelRs[0]->client->clientName}}" disabled="on">
        </div>
        <div class="inputother boxes2">
          <label for="contractSiteAddress"><i class="fas fa-map-marked-alt"></i> DIRECCIÓN:</label>
          <input type="text" style="cursor: no-drop" class="input-label" id="contractSiteAddress" name="contractSiteAddress" value="{{ $modelRs[0]->siteAddress}}" disabled="on">
        </div>
        <div class="inputother boxes2">
          <label for="projectDescriptionId"><i class="fas fa-cogs"></i> DESCRIPCION DEL PROYECTO</label>
          <select name="projectDescriptionId" id="projectDescriptionId" required="on">
            @foreach($projectDescriptions as $item)
              <option value="{{$item->projectDescriptionId}}" >{{$item->projectDescriptionName}}</option>
            @endforeach
          </select>
        </div>
        <div class="inputother boxes2">
          <label for="paymentConditionId"><i class="fas fa-money-check-alt"></i> CONDICION DE PAGO</label>
          <select name="paymentConditionId" id="paymentConditionId">
            @foreach($paymentConditions as $paymentC)
              <option value="{{$paymentC->pCondCode}}" >{{$paymentC->pCondName}}</option>
            @endforeach
          </select>
        </div>
        <div class="inputother boxes2">
          <label for="preinvoiceDate"><i class="fas fa-calendar-alt"></i> FECHA DE LA PROPUESTA:</label>
          <input class="input-label flatpickr" id="invoiceDate" name="invoiceDate" required>
        </div>
        <div class="inputother boxes2">  
        <label for="invoiceTaxPercent"><i class="fas fa-percent"></i> IMPUESTO</label>
          <input type="number" class="input-label" id="invoiceTaxPercent" name="invoiceTaxPercent" value="{{ $invoiceTaxPercent}}" required min="0.00" step="0.01">
        </div>
      </div>
    </div>
    <div style="width: 100%; text-align: center;">
      <button type="submit" class="submit">
        <span class="fa fa-check" aria-hidden="true"></span>  {{__('submit')}}
      </button>
      <a href="{{URL::previous()}}" class="return">
        <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
      </a>
    </div>
  </form>
</div>
@endsection
@push('styles')
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
@endpush
