@extends('layouts.master')
@section('content')
<div class="create">
  <form class="formulario" action="{{Route('invoices.update',['id' => $invoice[0]->invoiceId])}}" method="POST">
    <h3><i class="fas fa-file-alt"></i> Editar Factura: N° {{$invoice[0]->invId}}</h3>
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
      {{method_field('PUT')}}
      <input type="hidden" name="contractId" value="{{$invoice[0]->contractId}}">
      <div class="inputother boxes2">
        <label for="controlNumber"><i class="fas fa-book"></i> CONTRATO:</label>
        <input type="text" class="input-label" id="controlNumber" name="controlNumber" value="{{ $invoice[0]->contract->contractNumber}}" disabled="on">
      </div>
      <div class="inputother boxes2">
        <label for="clientName"><i class="fas fa-user-tie"></i> CLIENTE:</label>
        <input type="text" class="input-label" id="clientName" name="clientName" value="{{ $invoice[0]->client->clientName}}" disabled="on">
      </div>
      <div class="inputother boxes2">
        <label for="address"><i class="fas fa-map-marked-alt"></i> DIRECCIÓN:</label>
        <input type="text" class="input-label" id="address" name="address" value="{{ $invoice[0]->contract->siteAddress}}" disabled="on">
      </div>
      <div class="inputother boxes2">
        <label for="projectDescriptionId"><i class="fas fa-comment-alt"></i> DESCRIPCION DEL PROYECTO</label>
        <select name="projectDescriptionId" id="projectDescriptionId" required="on">
          @foreach($projectDescriptions as $item)
                @if ($item->projectDescriptionId == $invoice[0]->projectDescriptionId) 
                  <option value="{{$item->projectDescriptionId}}" selected>{{$item->projectDescriptionName}}</option>
                @else   
                  <option value="{{$item->projectDescriptionId}}">{{$item->projectDescriptionName}}</option>
                @endif   
            @endforeach</option>
        </select>
      </div> 
      <div class="inputother boxes2">
        <label for="paymentConditionId"><i class="fas fa-donate"></i> CONDICION DE PAGO</label>
        <select name="paymentConditionId" id="paymentConditionId">
          @foreach($paymentConditions as $paymentC)
                @if ($paymentC->pCondCode == $invoice[0]->pCondId)
                  <option value="{{$paymentC->pCondCode}}" selected>{{$paymentC->pCondName}}</option>
              @else
                  <option value="{{$paymentC->pCondCode}}" >{{$paymentC->pCondName}}</option>
            @endif
            @endforeach 
        </select>
      </div>
      <div class="inputother boxes2">
        <label for="invoiceDate"><i class="fas fa-calendar-alt"></i> FECHA DE LA FACTURA:</label>
        <input class="input-label flatpickr" id="invoiceDate" name="invoiceDate" value="{{ $invoice[0]->invoiceDate}}" required> 
      </div>
      <div class="inputother boxes2">
          <label for="taxPercent"><i class="fas fa-percent"></i> IMPUESTO</label>
          <input type="number" min="0.00" step="0.01" class="input-label" id="taxPercent" name="taxPercent" value="{{ $invoice[0]->taxPercent}}" required>
      </div>
      <div style="width: 100%; text-align: center;">
        <button type="submit" class="submit">
          <span class="fa fa-check" aria-hidden="true"></span>  {{__('save')}}
        </button>
            <a href="{{URL::previous()}}" class="return">
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