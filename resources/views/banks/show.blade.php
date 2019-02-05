@extends('layouts.master')

@section('content')

<div class="row">

    <div class="col-xs-6 col-offset-xs-1">
            <h3 class="text-danger"> ¿Eliminar Banco?</h3 >
                <form class="form-horizontal" action="{{Route('banks.destroy',['id' => $bank[0]->bankId])}}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                    <div class="form-group">
                      <label for="bankId" class="col-sm-2 control-label">ID</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="bankId" name="bankId"  value="{{$bank[0]->bankId}}" disabled>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="bankName" class="col-sm-2 control-label">NOMBRE DEL BANCO</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="bankName" name="bankName" value="{{$bank[0]->bankName}}" disabled>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-offset-2 col-sm-10">
                          <button type="submit" class="btn btn-danger">
                          <span class="fa fa-times-circle" aria-hidden="true"></span> {{__('delete')}}
                          </button>
                       <a href="{{route('banks.index')}}" class="btn btn-warning">
                          <span class="fa fa-hand-point-left" aria-hidden="true"></span> {{__('return')}}
                        </a>
                 
                      </div>
                    </div>
                  </form>
</div>
</div>

@endsection
