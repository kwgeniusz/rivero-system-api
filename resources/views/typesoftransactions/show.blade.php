@extends('layouts.master')

@section('content')

<div class="row">

    <div class="col-xs-6 col-offset-xs-1">
            <h3 class="text-danger">Esta seguro de eliminar este tipo de transaccion</h3 >
                <form class="form-horizontal" action="{{Route('transactionsTypes.destroy',['id' => $transaction[0]->transactionTypeId])}}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                    <div class="form-group">
                      <label for="transactionTypeId" class="col-sm-2 control-label">ID</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="transactionTypeId" name="transactionTypeId"  value="{{$transaction[0]->transactionTypeId}}" disabled>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="transactionTypeName" class="col-sm-2 control-label">{{__('name')}}</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="transactionTypeName" name="transactionTypeName" value="{{$transaction[0]->transactionTypeName}}" disabled>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="sign" class="col-sm-2 control-label"> TIPO</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="sign" name="sign" value="{{$transaction[0]->sign}}" disabled>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-offset-2 col-sm-10">
                          <button type="submit" class="btn btn-danger">
                          <span class="fa fa-times-circle" aria-hidden="true"></span> {{__('delete')}}
                          </button>
                       <a href="{{route('transactionsTypes.index')}}" class="btn btn-warning">
                          <span class="fa fa-hand-point-left" aria-hidden="true"></span> {{__('return')}}
                        </a>
                 
                      </div>
                    </div>
                  </form>
</div>
</div>

@endsection
