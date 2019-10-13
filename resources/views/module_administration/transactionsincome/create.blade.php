@extends('layouts.master')

@section('content')
<div class="col-xs-12 col-xs-offset-1">
<div class="panel panel-success col-xs-7">
    <div class="panel-heading"> <h3> <b>Nuevo Ingreso</b></h3></div>
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

        <form class="form" action="{{Route('transactions.store')}}" method="POST">
        {{csrf_field()}}
        <div class="row ">
          <div class="form-group col-xs-6">
                <label for="transactionTypeId">TIPO DE TRANSACCION</label>
                <select class="form-control" name="transactionTypeId">
                  @foreach($transactionType as $transaction)
                        <option value="{{$transaction->transactionTypeId}}" > {{$transaction->transactionTypeName}} </option>

                  @endforeach
              </select>
              </div>
              </div>

              <div class="form-group">
                <label for="description">DESCRIPCION</label>
                <input type="text" class="form-control" id="description" name="description" value="{{ old('description') }}" >
              </div>

              <div class="row ">
              <div class="form-group col-xs-4">
                <label for="transactionDate">FECHA</label>
                <input type="date" class="form-control flatpickr" id="transactionDate" name="transactionDate" value="{{ old('transactionDate') }}">
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


              <div class="row ">
                <div class="form-group col-xs-4">
                <label for="reference">REFERENCIA</label>
                <input type="text" class="form-control" id="reference" name="reference" value="{{ old('reference') }}" >
            </div>
            </div>

          <input type="hidden" name="sign" value="+">

            <div class="text-center">
              <button type="submit" class="btn btn-primary">
                <span class="fa fa-check" aria-hidden="true"></span>  {{__('save')}}
              </button>
              <a href="{{route('transactions.index',['sign' => '+'])}}" class="btn btn-warning">
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
