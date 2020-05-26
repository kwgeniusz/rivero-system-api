@extends('layouts.master')

@section('content')
<div class="col-xs-12 col-lg-7 col-lg-offset-2">
<div class="panel panel-danger ">
    <div class="panel-heading text-center"> <h3><b>¿Desea Eliminar Esta Transaccion de Egreso?</b></h3></div>
    <div class="panel-body">

            <form class="form form-prevent-multiple-submits" action="{{Route('transactions.delete',['sign'=> '-','id' => $transaction[0]->transactionId] )}}" method="POST">
              <center><modal-preview-document doc-url="{{$transaction[0]->document->docUrl}}" ext="{{$transaction[0]->document->mimeType}}"></modal-preview-document></center>
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
     @if($transaction[0]->cashboxId == null) 
                  <div class="col-xs-6">
                  <div class="form-group">
                    <label for="bankId">BANCO</label>
                    <input type="text" class="form-control" id="bankId" name="bankId" value="{{$transaction[0]->account->bank->bankName}}"  disabled>
                  </div>
                </div>

             <div class="col-xs-6">
                  <div class="form-group">
                    <label for="accountId">CUENTA DESTINO</label>
                    <input type="text" class="form-control" id="accountId" name="accountId" value="{{$transaction[0]->account->accountCodeId}}"  disabled>
                  </div>
                </div>
     @else
              <div class="col-xs-6">
                  <div class="form-group">
                    <label for="bankId">DESTINO</label>
                    <input type="text" class="form-control" id="bankId" name="bankId" value="CAJA"  disabled>
                  </div>
                </div>
     @endif 

                <div class="col-xs-6">
                  <div class="form-group">
                    <label for="reference">MOTIVO</label>
                    <input type="email" class="form-control" id="reference" name="reference" value="{{$transaction[0]->reason}}"  disabled>
                  </div>
                </div>

<div class="row"></div>
                <div class="text-center">
                  <button type="submit" class="btn btn-danger button-prevent-multiple-submits">
                    <span class="fa fa-times-circle" aria-hidden="true"></span>  {{__('delete')}}
                  </button>
                  <a href="{{route('transactions.index',['sign' => '-'])}}" class="btn btn-warning">
                      <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
                  </a>

              </form>
        </div>

      </div>
    </div>
  </div>
@endsection
