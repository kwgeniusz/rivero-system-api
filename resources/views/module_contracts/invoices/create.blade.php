@extends('layouts.master')

@section('content')
<div class="col-xs-12 col-xs-offset-1">
<div class="panel panel-success col-xs-7">
    <div class="panel-heading"> <h3><b>Nueva Factura: N° {{$invoiceNumberFormat}}</b></h3></div>
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
        <form class="form" action="{{Route('invoices.store')}}" method="POST">
        {{csrf_field()}}
      <input type="hidden" name="contractId" value="{{$contract[0]->contractId}}">
       <div class="row">
          <div class="form-group col-xs-4">
            <label for="contractNumber">CONTRATO:</label>
            <input type="text" class="form-control" id="contractNumber" name="contractNumber" value="{{ $contract[0]->contractNumber}}" disabled="on">
          </div>
        </div>

              <div class="form-group">
                <label for="clientName">CLIENTE:</label>
                <input type="text" class="form-control" id="clientName" name="clientName" value="{{ $contract[0]->client->clientName}}" disabled="on">
              </div>

              <div class="form-group">
                <label for="contractSiteAddress">DIRECCIÓN:</label>
                <input type="text" class="form-control" id="contractSiteAddress" name="contractSiteAddress" value="{{ $contract[0]->siteAddress}}" disabled="on">
              </div>

            <div class="form-group">
            <label for="paymentConditionId">CONDICION DE PAGO</label>
            <select class="form-control" name="paymentConditionId" id="paymentConditionId">
                @foreach($paymentConditions as $paymentC)
                      <option value="{{$paymentC->pCondId}}" >
                        @php echo ($paymentC->pCondNameEn) ? $paymentC->pCondNameEn : $paymentC->pCondNameSp @endphp
                     </option>
                @endforeach
            </select>
          </div>

        <div class="row">
          <div class="form-group col-xs-5">
              <label for="invoiceDate">FECHA DE LA FACTURA:</label>
              <input class="form-control flatpickr" id="invoiceDate" name="invoiceDate" required> 
            </div>

        <div class="form-group col-xs-4">
            <label for="invoiceTaxPercent">IMPUESTO (%)</label>
            <input type="number" min="0.00" step="0.01" class="form-control" id="invoiceTaxPercent" name="invoiceTaxPercent" value="{{ $invoiceTaxPercent}}" required>
        </div>
        </div>
      
            <div class="text-center">
              <button type="submit" class="btn btn-primary">
                <span class="fa fa-check" aria-hidden="true"></span>  {{__('save')}}
              </button>
              <a href="{{route('invoices.index', ['id' => $contract[0]->contractId])}}" class="btn btn-warning">
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
