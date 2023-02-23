@extends('layouts.master')
@section('content')
<div class="create">
  <form class="formulario" action="{{Route('invoices.store')}}" method="POST">
    {{csrf_field()}}
    <h3><i class="fas fa-file-alt"></i> Nueva Factura: N° {{$invId}}</h3>
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
      <input type="hidden" name="contractId" value="{{$contract[0]->contractId}}">
      <div class="inputother boxes2">
        <label for="contractNumber"><i class="fas fa-book"></i> CONTRATO:</label>
        <input type="text" class="input-label" id="contractNumber" name="contractNumber" value="{{ $contract[0]->contractNumber}}" disabled="on">
      </div>
      <div class="inputother boxes2">
        <label for="clientName"><i class="fas fa-user-tie"></i> CLIENTE:</label>
        <input type="text" class="input-label" id="clientName" name="clientName" value="{{ $contract[0]->client->clientName}}" disabled="on">
      </div>
      <div class="inputother boxes2">
        <label for="contractSiteAddress"><i class="fas fa-map-marked-alt"></i> DIRECCIÓN:</label>
        <input type="text" class="input-label" id="contractSiteAddress" name="contractSiteAddress" value="{{ $contract[0]->siteAddress}}" disabled="on">
      </div>
      <div class="inputother boxes2">
        <label for="projectDescriptionId"><i class="fas fa-comment-alt"></i> DESCRIPCION DEL PROYECTO</label>
        <select name="projectDescriptionId" id="projectDescriptionId" required="on">
          @foreach($projectDescriptions as $item)
            <option value="{{$item->projectDescriptionId}}" >{{$item->projectDescriptionName}}</option>
          @endforeach
        </select>
      </div>
      <div class="inputother boxes2">
        <label for="paymentConditionId"><i class="fas fa-donate"></i> CONDICION DE PAGO</label>
        <select name="paymentConditionId" id="paymentConditionId">
          @foreach($paymentConditions as $paymentC)
            <option value="{{$paymentC->pCondCode}}" >{{$paymentC->pCondName}}</option>
          @endforeach
        </select>
      </div>
      <div class="inputother boxes2">
        <label for="invoiceDate"><i class="fas fa-calendar-alt"></i> FECHA DE LA FACTURA:</label>
        <input class="input-label flatpickr" id="invoiceDate" name="invoiceDate" required> 
      </div>
      <div class="inputother boxes2">
        <label for="invoiceTaxPercent"><i class="fas fa-percent"></i> IMPUESTO</label>
        <input type="number" min="0.00" step="0.01" class="input-label" id="invoiceTaxPercent" name="invoiceTaxPercent" value="{{ $invoiceTaxPercent}}" required>
      </div>
      <div style="width: 100%; text-align: center;">
        <button type="submit" class="submit">
          <span class="fa fa-check" aria-hidden="true"></span>  {{__('save')}}
        </button>
        <a href="{{route('invoices.index', ['id' => $contract[0]->contractId])}}" class="return">
          <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
        </a>
      </div>
    </div>
  </form>
</div>
@endsection
@push('styles')
  <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
@endpush
