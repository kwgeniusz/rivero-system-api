@extends('layouts.master')

@section('content')

<div class="col-xs-12 col-xs-offset-1">
<div class="panel panel-danger col-xs-7">
    <div class="panel-heading"> <h3><b>¿Esta Seguro de Eliminar este Pre-Contrato?</b></h3></div>
    <div class="panel-body">

      <form class="form-horizontal" action="{{Route('precontracts.destroy',['id' => $precontract[0]->precontractId])}}" method="POST">
        {{csrf_field()}}
        {{method_field('DELETE')}}
        <div class="form-group">
          <label class="col-sm-5 control-label">N°</label>
          <div class="col-sm-7">
            <p class="form-control-static">{{ $precontract[0]->precontractId }}</p>
          </div>
        </div>
      <div class="col-xs-6">
        <div class="form-group">
          <label class="col-sm-5 control-label">{{__('country')}}</label>
          <div class="col-sm-7">
            <p class="form-control-static">{{ $precontract[0]->country->countryName }}</p>
          </div>
        </div>
     </div>

       <div class="col-xs-6">
        <div class="form-group">
          <label class="col-sm-5 control-label">{{__('office')}}</label>
          <div class="col-sm-7">
            <p class="form-control-static">{{ $precontract[0]->office->officeName }}</p>
          </div>
        </div>
       </div>
        <div class="form-group">
          <label class="col-sm-5 control-label">{{__('client')}}</label>
          <div class="col-sm-7">
            <p class="form-control-static">{{ $precontract[0]->client->clientName }}</p>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-5 control-label">{{__('address')}}</label>
          <div class="col-sm-7">
            <p class="form-control-static">{{ $precontract[0]->siteAddress }}</p>
          </div>
        </div>
          <div class="form-group">
          <label class="col-sm-5 control-label">DESCRIPCION DE PROYECTO</label>
          <div class="col-sm-7">
            <p class="form-control-static">{{ $precontract[0]->projectType->projectTypeName }}</p>
          </div>
        </div>
         <div class="form-group">
          <label class="col-sm-5 control-label">TIPO DE PROYECTO</label>
          <div class="col-sm-7">
            <p class="form-control-static">{{ $precontract[0]->serviceType->serviceTypeName }}</p>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-5 control-label">{{__('initial_comment')}}</label>
          <div class="col-sm-7">
            <p class="form-control-static">{{ $precontract[0]->comment }}</p>
          </div>
        </div>
       <div class="col-xs-6">
        <div class="form-group">
          <label class="col-sm-5 control-label">{{__('contract_cost')}}</label>
          <div class="col-sm-7">
            <p class="form-control-static">{{  number_format( $precontract[0]->precontractCost, 2, ',', '.')}}</p>
          </div>
        </div>
      </div>
      <div class="col-xs-6">
        <div class="form-group">
          <label class="col-sm-5 control-label">{{__('currency')}}</label>
          <div class="col-sm-7">
            <p class="form-control-static">{{ $precontract[0]->currencyName }}</p>
          </div>
        </div>
      </div>



            <div class="text-center">
              <button type="submit" class="btn btn-danger">
                <span class="fa fa-times-circle" aria-hidden="true"></span>  {{__('delete')}}
              </button>
              <a href="{{route('precontracts.index')}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
              </a>
            </div>
            </div>
          </form>


    </div>

  </div>

@endsection
