@extends('layouts.master')

@section('content')
<div class="col-xs-12 col-xs-offset-1">
<div class="panel panel-danger col-xs-7">
    <div class="panel-heading"> <h3> <b>Nuevo Egreso</b></h3></div>
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
        <form class="form form-prevent-multiple-submits" action="{{Route('transactions.store')}}" method="POST" enctype="multipart/form-data">
        {{csrf_field()}}
              <div class="row ">
              <div class="form-group col-xs-4">
                <label for="transactionDate">FECHA:</label>
                <input type="date" class="form-control flatpickr" id="transactionDate" name="transactionDate" value="{{ old('transactionDate') }}">
              </div>
            </div>
              <div class="form-group">
                <label for="description">REFERENCIA EN BANCO O NOMBRE DE BENEFICIARIO:</label>
                <input type="text" class="form-control" id="description" name="description" value="{{ old('description') }}">
              </div>
            <div class="row ">
             <div class="form-group col-xs-6">
                <label for="payMethodId">METODO DE PAGO:</label>
                <select class="form-control" name="payMethodId">
                  @foreach($paymentsMethod as $paymentMethod)
                        <option value="{{$paymentMethod->payMethodId}}" > {{$paymentMethod->payMethodName}} </option>
                  @endforeach
              </select>
              </div>
              </div>

              <div class="form-group">
                <label for="payMethodDetails">DETALLES DEL METODO:</label>
                <input type="text" class="form-control" id="payMethodDetails" name="payMethodDetails" value="{{ old('payMethodDetails') }}" placeholder="N° DE TDD,TDC,CUENTA,CHEQUE...">
              </div>
             
             <div class="form-group">
                <label for="reason">MOTIVO:</label>
                <input type="text" class="form-control" id="reason" name="reason" value="{{ old('reason') }}" placeholder="">
              </div>

    <div class="row ">
          <div class="form-group col-xs-6">
                <label for="transactionTypeId">EXPENSES:</label>
                <select class="form-control" name="transactionTypeId">
                  @foreach($transactionType as $transaction)
                        <option value="{{$transaction->transactionTypeId}}" > {{$transaction->transactionTypeName}} </option>
                  @endforeach
              </select>
              </div>
        </div>

            <div class="row ">
              <div class="form-group col-xs-4">
                <label for="amount">MONTO</label>
                <input type="number" class="form-control" step="0.01" id="amount" name="amount" value="{{ old('amount') }}">
              </div>
              </div>

              <div class="row ">
                <div class="form-group col-xs-6">
                <label for="bankId">BANCO</label>
                <select class="form-control" name="bankId">
                  @foreach($banks as $bank)
                        <option value="{{$bank->bankId}}" > {{$bank->bankName}} </option>
                  @endforeach
              </select>
              </div>
              </div>

 <!--           <div class="row ">
                <div class="form-group col-xs-6">
                <label for="bankId">COMPROBANTE DE EGRESO</label>
                <input type="file" name="file">
              </div>
          </div>
              -->

          <input type="hidden" name="sign" value="-">
          <input type="hidden" name="invoiceId" value="0">

            <div class="text-center">
              <button type="submit" class="btn btn-primary button-prevent-multiple-submits">
                <span class="fa fa-check" aria-hidden="true"></span>  {{__('save')}}
              </button>
              <a href="{{route('transactions.index',['sign' => '-'])}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
              </a>
            </div>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>
@endsection
