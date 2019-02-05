@extends('layouts.master')

@section('content')

<div class="row">

    <div class="col-xs-5 col-offset-xs-1">
            <h3 class="text-success">Modificar Datos del Banco</h3 >
                <form class="form-horizontal" action="{{Route('banks.update',['id' => $bank[0]->bankId])}}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                    <div class="form-group">
                      <label for="bankId" class="col-sm-2 control-label">ID</label>
                      <div class="col-sm-10">
                        <input  type="text" class="form-control" id="bankId" name="bankId"  value="{{$bank[0]->bankId}}" disabled>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="bankName" class="col-sm-2 control-label">{{__('name')}}</label>
                      <div class="col-sm-10">
                        <input  type="text" class="form-control" id="bankName" name="bankName" value="{{$bank[0]->bankName}}" >
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="initialBalance" class="col-sm-5 control-label">SALDO INICIAL</label>
                      <div class="col-sm-4">
                        <input style="text-align:right;" type="number" step="0.01" class="form-control" id="initialBalance" name="initialBalance" value="{{$bank[0]->initialBalance}}" >
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="balance01" class="col-sm-5 control-label">SALDO ENERO (01)</label>
                      <div  class="col-sm-4">
                        <input  style="text-align:right;"  type="number" step="0.01" class="form-control" id="balance01" name="balance01" value="{{$bank[0]->balance01}}" >
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="balance02" class="col-sm-5 control-label">SALDO FEBRERO (02)</label>
                      <div class="col-sm-4">
                        <input  style="text-align:right;" type="number" step="0.01" class="form-control" id="balance02" name="balance02" value="{{$bank[0]->balance02}}" >
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="balance03" class="col-sm-5 control-label">SALDO MARZO (03)</label>
                      <div class="col-sm-4">
                        <input  style="text-align:right;" type="number" step="0.01" class="form-control" id="balance03" name="balance03" value="{{$bank[0]->balance03}}" >
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="balance04" class="col-sm-5 control-label">SALDO ABRIL (04)</label>
                      <div class="col-sm-4">
                        <input  style="text-align:right;" type="number" step="0.01" class="form-control" id="balance04" name="balance04" value="{{$bank[0]->balance04}}" >
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="balance05" class="col-sm-5 control-label">SALDO MAYO (05)</label>
                      <div class="col-sm-4">
                        <input  style="text-align:right;" type="number" step="0.01" class="form-control" id="balance05" name="balance05" value="{{$bank[0]->balance05}}" >
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="balance06" class="col-sm-5 control-label">SALDO JUNIO (06)</label>
                      <div class="col-sm-4">
                        <input  style="text-align:right;" type="number" step="0.01" class="form-control" id="balance06" name="balance06" value="{{$bank[0]->balance06}}" >
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="balance07" class="col-sm-5 control-label">SALDO JULIO (07)</label>
                      <div class="col-sm-4">
                        <input  style="text-align:right;" type="number" step="0.01" class="form-control" id="balance07" name="balance07" value="{{$bank[0]->balance07}}" >
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="balance08" class="col-sm-5 control-label">SALDO AGOSTO (08)</label>
                      <div class="col-sm-4">
                        <input  style="text-align:right;" type="number" step="0.01" class="form-control" id="balance08" name="balance08" value="{{$bank[0]->balance08}}" >
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="balance09" class="col-sm-5 control-label">SALDO SEPTIEMBRE (09)</label>
                      <div class="col-sm-4">
                        <input  style="text-align:right;" type="number" step="0.01" class="form-control" id="balance09" name="balance09" value="{{$bank[0]->balance09}}" >
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="balance10" class="col-sm-5 control-label">SALDO OCTUBRE (10)</label>
                      <div class="col-sm-4">
                        <input  style="text-align:right;" type="number" step="0.01" class="form-control" id="balance10" name="balance10" value="{{$bank[0]->balance10}}" >
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="balance11" class="col-sm-5 control-label">SALDO NOVIEMBRE (11)</label>
                      <div class="col-sm-4">
                        <input  style="text-align:right;" type="number" step="0.01" class="form-control" id="balance11" name="balance11" value="{{$bank[0]->balance11}}" >
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="balance12" class="col-sm-5 control-label">SALDO DICIEMBRE (12)</label>
                      <div class="col-sm-4">
                        <input  style="text-align:right;" type="number" step="0.01" class="form-control" id="balance12" name="balance12" value="{{$bank[0]->balance12}}" >
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="col-sm-offset-2 col-sm-10">
                       <button type="submit" class="btn btn-primary">
                          <span class="fa fa-check" aria-hidden="true"></span>   {{__('update')}}
                        </button>
                       <a href="{{route('banks.index')}}" class="btn btn-warning">
                          <span class="fa fa-hand-point-left" aria-hidden="true"></span>   {{__('return')}}
                        </a>
                      </div>
                    </div>

                  </form>
</div>
</div>

@endsection
