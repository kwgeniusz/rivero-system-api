@extends('layouts.master')

@section('content')
<div class="create">
  <form  class="formulario" action="{{Route('proposals.update',['proposal' => $proposal[0]->proposalId])}}" method="POST">
    <div>
      <h3><i class="fas fa-book"></i> Editar Propuesta: N° {{$proposal[0]->propId}}</h3>
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
        @if($proposal[0]->contractId ==null)       
        <input type="hidden" name="precontractId" value="{{$proposal[0]->precontractId}}">
        @else
        <input type="hidden" name="contractId" value="{{$proposal[0]->contractId}}">
        @endif
        <div class="inputother boxes2">
          <label for="clientName"><i class="fas fa-user-tie"></i> CLIENTE:</label>
          <input type="text" style="cursor: no-drop" class="input-label" id="clientName" name="clientName" value="{{ $proposal[0]->client->clientName}}" disabled="on">
        </div>
        <div class="inputother boxes2">
          <label for="address"><i class="fas fa-map-marked-alt"></i> DIRECCIÓN:</label>
            @if($proposal[0]->contractId ==null)       
              <input type="text" style="cursor: no-drop" class="input-label" id="address" name="address" value="{{ $proposal[0]->precontract->siteAddress}}" disabled="on">
            @else
              <input type="text" style="cursor: no-drop" class="input-label" id="address" name="address" value="{{ $proposal[0]->contract->siteAddress}}" disabled="on">
            @endif 
        </div>
        <div class="inputother boxes2">
          <label for="projectDescriptionId"><i class="fas fa-cogs"></i> DESCRIPCION DEL PROYECTO</label>
          <select name="projectDescriptionId" id="projectDescriptionId" required="on">
            @foreach($projectDescriptions as $item)
              @if ($item->projectDescriptionId == $proposal[0]->projectDescriptionId) 
                <option value="{{$item->projectDescriptionId}}" selected>{{$item->projectDescriptionName}}</option>
              @else   
                <option value="{{$item->projectDescriptionId}}">{{$item->projectDescriptionName}}</option>
              @endif   
            @endforeach
          </select>
        </div>
        <div class="inputother boxes2">
          <label for="paymentConditionId"><i class="fas fa-money-check-alt"></i> CONDICION DE PAGO</label>
          <select name="paymentConditionId" id="paymentConditionId">
            @foreach($paymentConditions as $paymentC)
              @if ($paymentC->pCondCode == $proposal[0]->pCondId)
                <option value="{{$paymentC->pCondCode}}" selected>{{$paymentC->pCondName}}</option>
              @else
                <option value="{{$paymentC->pCondCode}}" >{{$paymentC->pCondName}}</option>
              @endif
            @endforeach 
          </select>
        </div>
        <div class="inputother boxes2">
          <label for="proposalDate"><i class="fas fa-calendar-alt"></i> FECHA DE LA PROPUESTA:</label>
          <input class="input-label flatpickr" id="proposalDate" name="proposalDate" value="{{ $proposal[0]->proposalDate}}" required>
        </div>
        <div class="inputother boxes2">  
        <label for="invoiceTaxPercent"><i class="fas fa-percent"></i> IMPUESTO</label>
          <input type="number" class="input-label" id="invoiceTaxPercent" name="invoiceTaxPercent" value="{{ $proposal[0]->taxPercent}}" required min="0.00" step="0.01">
        </div>
      </div>
    </div>
    <div style="width: 100%; text-align: center;">
      <button type="submit" class="submit">
        <span class="fa fa-check" aria-hidden="true"></span>  {{__('save')}}
      </button>
      <a href="{{URL::previous()}}" class="return">
        <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
      </a> 
      {{-- @if($proposal[0]->contractId ==null)   
        <a href="{{route('proposals.index', ['id' => $proposal[0]->precontractId])}}" class="return">
          <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
        </a>
      @else
        <a href="{{route('invoices.index', ['id' => $proposal[0]->contractId])}}" class="return">
          <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
        </a>
      @endif --}}
    </div>
  </form>
</div>
@endsection
