@extends('layouts.master')

@section('content')

<div class="col-xs-12 col-xs-offset-1">
<div class="panel panel-warning col-xs-7">
    <div class="panel-heading"> <h3><b>¿Esta Seguro de Convertir este Precontrato a Contrato?</b></h3></div>
    <div class="panel-body">

      <form class="form-horizontal form-prevent-multiple-submits" action="{{Route('precontracts.convertAgg',['id' => $proposal[0]->proposalId])}}" method="POST">
        {{csrf_field()}}
        <div class="form-group">
          <label class="col-sm-5 control-label">N°</label>
          <div class="col-sm-7">
            <p class="form-control-static">{{ $precontract->preId }}</p>
          </div>
        </div>
           
      <div class="col-xs-6">
        <div class="form-group">
          <label class="col-sm-5 control-label">{{__('country')}}</label>
          <div class="col-sm-7">
            <p class="form-control-static">{{ $precontract->country->countryName }}</p>
          </div>
        </div>
     </div>

       <div class="col-xs-6">
        <div class="form-group">
          <label class="col-sm-5 control-label">{{__('office')}}</label>
          <div class="col-sm-7">
            <p class="form-control-static">{{ $precontract->office->officeName }}</p>
          </div>
        </div>
       </div>
      <div class="form-group">
          <label class="col-sm-5 control-label">FECHA</label>
          <div class="col-sm-7">
            <p class="form-control-static">{{ $precontract->precontractDate }}</p>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-5 control-label">{{__('client')}}</label>
          <div class="col-sm-7">
            <p class="form-control-static">{{ $precontract->client->clientName }}</p>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-5 control-label">TIPO DE CONTRATO</label>
          <div class="col-sm-7">
            <p class="form-control-static">{{ $precontract->contractType }}</p>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-5 control-label">{{__('address')}}</label>
          <div class="col-sm-7">
            <p class="form-control-static">{{ $precontract->siteAddress }}</p>
          </div>
        </div>
          <div class="form-group">
          <label class="col-sm-5 control-label">DESCRIPCION DE PROYECTO</label>
          <div class="col-sm-7">
            <p class="form-control-static">{{ $precontract->projectDescription->projectDescriptionName }}</p>
          </div>
        </div>
         <div class="form-group">
          <label class="col-sm-5 control-label">TIPO DE PROYECTO</label>
          <div class="col-sm-7">
            <p class="form-control-static">{{ $precontract->projectUse->projectUseName }}</p>
          </div>
        </div>
           <div class="form-group">
          <label class="col-sm-5 control-label">{{__('initial_comment')}}</label>
          <div class="col-sm-7">
            <p class="form-control-static">{{ $precontract->comment }}</p>
          </div>
        </div>
       <div class="col-xs-6">
        <div class="form-group">
          <label class="col-sm-5 control-label">{{__('contract_cost')}}</label>
          <div class="col-sm-7">
            <p class="form-control-static">{{  number_format( $precontract->precontractCost, 2, ',', '.')}}</p>
          </div>
        </div>
      </div>
      <div class="col-xs-6">
        <div class="form-group">
          <label class="col-sm-5 control-label">{{__('currency')}}</label>
          <div class="col-sm-7">
            <p class="form-control-static">{{ $precontract->currency->currencyName }}</p>
          </div>
        </div>
      </div>




            <div class="text-center">
              <button type="submit" class="btn btn-success  button-prevent-multiple-submits">
                <span class="fa fa-sync" aria-hidden="true"></span>  Convertir
              </button>
              <a href="{{url("/proposals?id=$precontract->precontractId")}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
              </a>
            </div>
            </div>
          </form>


    </div>

  </div>

@endsection
