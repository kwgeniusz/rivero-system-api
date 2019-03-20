@extends('layouts.master')

@section('content')
<div class="col-xs-12 col-xs-offset-1">
<div class="panel panel-danger col-xs-7">
    <div class="panel-heading"> <h3><b>¿Desea Eliminar Esta Transaccion de Egreso?</b></h3></div>
    <div class="panel-body">
      <div class="row ">
          <div class="col-xs-12 ">


            <form class="form" action="{{Route('transactions.delete',['sign'=> '-','id' => $transaction[0]->transactionId] )}}" method="POST">
              {{ csrf_field() }}
              {{ method_field('DELETE') }}
                  <div class="form-group">
                    <label for="transactionId"> ID</label>
                    <input type="text" class="form-control" id="transactionId" name="transactionId" value="{{$transaction[0]->transactionId}}"  disabled>
                  </div>
                  <div class="form-group">
                    <label for="transactionTypeId"> TIPO DE TRANSACCION</label>
                    <input type="text" class="form-control" id="transactionTypeId" name="transactionTypeId" value="{{$transaction[0]->transactionType->transactionTypeName}}"  disabled>
                  </div>
                  <div class="form-group">
                    <label for="description">DESCRIPCION</label>
                    <input type="text" class="form-control" id="description" name="description" value="{{$transaction[0]->description}}" disabled>
                  </div>

                  <div class="form-group">
                    <label for="transactionDate">FECHA</label>
                    <input type="text" class="form-control" id="transactionDate" name="transactionDate" value="{{$transaction[0]->transactionDate}}"  disabled>
                  </div>
                  <div class="form-group">
                    <label for="amount">MONTO</label>
                    <input type="text" class="form-control" id="amount" name="amount" value="{{$transaction[0]->amount}}"  disabled>
                  </div>

                  <div class="col-xs-6">
                  <div class="form-group">
                    <label for="bankId">BANCO</label>
                    <input type="text" class="form-control" id="bankId" name="bankId" value="{{$transaction[0]->bank->bankName}}"  disabled>
                  </div>
                </div>
                <div class="col-xs-6">
                  <div class="form-group">
                    <label for="reference">REFERENCIA</label>
                    <input type="email" class="form-control" id="reference" name="reference" value="{{$transaction[0]->reference}}"  disabled>
                  </div>
                </div>

                <div class="text-center">
                  <button type="submit" class="btn btn-danger">
                    <span class="fa fa-times-circle" aria-hidden="true"></span>  {{__('delete')}}
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
